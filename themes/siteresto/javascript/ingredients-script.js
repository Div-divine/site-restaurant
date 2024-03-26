document.addEventListener('DOMContentLoaded', function () {
    var saveButton = document.getElementById('save-button');
    if (saveButton) {
        saveButton.addEventListener('click', function (event) { // Add event parameter here
            // Prevent the default form submission behavior
            event.preventDefault();

            var quantite = document.getElementById('quantite').value;
            var unite = document.getElementById('unite').value;
            var selectedTags = document.getElementById('form-select').value;
            var savedContentDiv = document.getElementById('saved-content');
            var unitDefaultOption = document.getElementById('option-unite').value;
            var unitDefaultOption = document.getElementById('option-unite').value;
            var ingredientDefaultOption = document.getElementById('option-ingedients').value;
            var errorMsgIngredient = document.getElementById('error-msg-ingredient');
            
            if (unite != unitDefaultOption) {
                // Construct the content to be appended to the editor
                var contentToAppend = '<li>' + quantite + ' ' + unite + ' ' + selectedTags + '</li>';

            } else {
                contentToAppend = '<li>' + quantite + ' ' + ' ' + selectedTags + '</li>';
            }

            if (selectedTags != ingredientDefaultOption) {
                // Add contents to the div
                savedContentDiv.innerHTML += '<div>' + contentToAppend + '</div>';

                // Reset input fields
                document.getElementById('quantite').value = '';
                document.getElementById('unite').value = document.getElementById('option-unite').value;
                document.getElementById('form-select').value = document.getElementById('option-ingedients').value;

                // Get the WordPress editor instance
                var editor = tinyMCE.get('content');

                // Check if the editor is available
                if (editor) {
                    // Remove leading/trailing whitespace and line breaks from the content
                    contentToAppend = contentToAppend.trim();
                    // Insert the content into the editor
                    editor.insertContent(contentToAppend);
                    errorMsgIngredient.style.display = "none";
                } else {
                    console.error('Editor not found.');
                }
            } else {
                errorMsgIngredient.style.display = "block";
            }

        });
    } else {
        console.error('Save button element not found.');
    }
});
