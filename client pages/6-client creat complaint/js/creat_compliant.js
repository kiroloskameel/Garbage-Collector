document.addEventListener('DOMContentLoaded', function() {
    var submitButton = document.querySelector('input[type="submit"]');
    submitButton.addEventListener('click', function(event) {
        var confirmSubmit = confirm("Are you sure you want to submit?");
        if (!confirmSubmit) {
            event.preventDefault();
        }
    });
});
