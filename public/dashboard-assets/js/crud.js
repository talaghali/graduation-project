/**
 * Post function for CREATE operations
 * @param {string} url - API endpoint
 * @param {object|FormData} data - Data to send (can be regular object or FormData for file uploads)
 * @param {string} buttonId - Submit button ID to disable
 * @param {string} redirectTo - URL to redirect after success
 * @param {string} formId - Form ID to reset after success (optional)
 */
function post(url, data, buttonId, redirectTo, formId) {
    if (buttonId != undefined) {
        const button = document.getElementById(buttonId);
        const originalText = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Creating...';
    }

    // Determine if data is FormData or regular object
    const isFormData = data instanceof FormData;
    const config = isFormData ? {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    } : {};

    axios.post(url, data, config)
        .then((response) => {
            if (formId != undefined) {
                document.getElementById(formId).reset();
                // Reset TinyMCE if exists
                if (typeof tinymce !== 'undefined' && tinymce.get('content')) {
                    tinymce.get('content').setContent('');
                }
            }
            Toast.fire({
                icon: 'success',
                title: response.data.message,
            });
            if (redirectTo != undefined) {
                setTimeout(() => {
                    window.location.href = redirectTo;
                }, 700);
            } else {
                if (buttonId != undefined) {
                    const button = document.getElementById(buttonId);
                    button.disabled = false;
                    button.innerHTML = originalText;
                }
            }
        })
        .catch((error) => {
            let errorMessage = 'An error occurred. Please try again.';

            if (error.response?.data?.errors) {
                const errors = Object.values(error.response.data.errors).flat();
                errorMessage = errors.join('<br>');
            } else if (error.response?.data?.message) {
                errorMessage = error.response.data.message;
            }

            Toast.fire({
                icon: 'error',
                title: errorMessage,
            });

            if (buttonId != undefined) {
                const button = document.getElementById(buttonId);
                button.disabled = false;
                button.innerHTML = originalText;
            }
        });
}

/**
 * Put function for UPDATE operations
 * @param {string} url - API endpoint
 * @param {object|FormData} data - Data to send (can be regular object or FormData for file uploads)
 * @param {string} buttonId - Submit button ID to disable
 * @param {string} redirectTo - URL to redirect after success
 * @param {string} formId - Form ID (optional)
 */
function put(url, data, buttonId, redirectTo, formId) {
    let originalText = '';

    if (buttonId != undefined) {
        const button = document.getElementById(buttonId);
        originalText = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';
    }

    // If data is FormData, we need to use POST with _method field
    const isFormData = data instanceof FormData;

    if (isFormData) {
        // Add _method for Laravel
        data.append('_method', 'PUT');

        axios.post(url, data, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then((response) => {
            handleUpdateSuccess(response, formId, redirectTo, buttonId, originalText);
        })
        .catch((error) => {
            handleUpdateError(error, buttonId, originalText);
        });
    } else {
        axios.put(url, data)
            .then((response) => {
                handleUpdateSuccess(response, formId, redirectTo, buttonId, originalText);
            })
            .catch((error) => {
                handleUpdateError(error, buttonId, originalText);
            });
    }
}

function handleUpdateSuccess(response, formId, redirectTo, buttonId, originalText) {
    if (formId != undefined) {
        document.getElementById(formId).reset();
    }
    Toast.fire({
        icon: 'success',
        title: response.data.message,
    });
    if (redirectTo != undefined) {
        setTimeout(() => {
            window.location.href = redirectTo;
        }, 700);
    } else {
        if (buttonId != undefined) {
            const button = document.getElementById(buttonId);
            button.disabled = false;
            button.innerHTML = originalText;
        }
    }
}

function handleUpdateError(error, buttonId, originalText) {
    let errorMessage = 'An error occurred. Please try again.';

    if (error.response?.data?.errors) {
        const errors = Object.values(error.response.data.errors).flat();
        errorMessage = errors.join('<br>');
    } else if (error.response?.data?.message) {
        errorMessage = error.response.data.message;
    }

    Toast.fire({
        icon: 'error',
        title: errorMessage,
    });

    if (buttonId != undefined) {
        const button = document.getElementById(buttonId);
        button.disabled = false;
        button.innerHTML = originalText;
    }
}

/**
 * SweetAlert mixin for confirmation dialogs
 */
const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger',
    },
    buttonsStyling: false,
});

/**
 * Delete function with confirmation
 * @param {string} url - API endpoint
 * @param {HTMLElement} ref - Reference to the row element to remove
 */
function deleteItem(url, ref) {
    swalWithBootstrapButtons
        .fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true,
        })
        .then((result) => {
            if (result.isConfirmed) {
                performDelete(url, ref);
            }
        });
}

/**
 * Perform the actual delete operation
 * @param {string} url - API endpoint
 * @param {HTMLElement} ref - Reference to the row element to remove
 */
function performDelete(url, ref) {
    axios
        .delete(url)
        .then((response) => {
            if (ref) {
                ref.closest('tr').remove();
            }
            swalWithBootstrapButtons.fire(
                'Deleted!',
                response.data.message,
                'success'
            );
        })
        .catch((error) => {
            swalWithBootstrapButtons.fire(
                'Error',
                error.response?.data?.message || 'An error occurred while deleting.',
                'error'
            );
        });
}
