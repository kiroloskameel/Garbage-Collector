document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("#contact form");
    const errorMessage = document.querySelector("#error-message");

    form.addEventListener("submit", async function(event) {
        event.preventDefault();

        errorMessage.textContent = "";
        errorMessage.style.display = "none";

        try {
            const formData = new FormData(form);

            const formDataObject = {};
            formData.forEach((value, key) => {
                formDataObject[key] = value;
            });

            console.log(formDataObject);

            const response = await fetch("home.php", {
                method: "POST",
                body: JSON.stringify(formDataObject),
                headers: {
                    "Content-Type": "application/json"
                }
            });

            if (!response.ok) {
                throw new Error("Network response was not ok");
            }

            form.reset();

            alert("Form submitted successfully!");
        } catch (error) {

            errorMessage.textContent = "There was a problem submitting the form. Please try again later.";
            errorMessage.style.display = "block";
            console.error("Error submitting form:", error);
        }
    });
});
