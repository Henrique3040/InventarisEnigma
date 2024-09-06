document.addEventListener('DOMContentLoaded', function() {
    // Handle edit button click only if edit buttons exist
    const editButtons = document.querySelectorAll('.edit-button');
    if (editButtons.length > 0) {
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const quantity = this.getAttribute('data-quantity');
                const categoryId = this.getAttribute('data-category');

                // Set the values of the form fields with the product data
                document.getElementById('product-id').value = id;
                document.getElementById('edit-product-name').value = name;
                document.getElementById('edit-quantity').value = quantity;

                // Pre-select the category
                const categorySelect = document.getElementById('edit-category');
                categorySelect.value = categoryId;

                // Dynamically set the form action for updating the product
                const form = document.getElementById('edit-product-form');
                form.action = `/producten/${id}`;

                // Show the modal
                document.getElementById('edit-form-container').style.display = 'block';
            });
        });
    } else {
        console.log('No products available to edit.');
    }

    // Handle new category creation
    const createCategoryForm = document.getElementById('createCategoryForm');
    if (createCategoryForm) {
        createCategoryForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            console.log('Creating new category...');
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    name: document.getElementById('new_category_name').value
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    return response.text().then(text => {
                        throw new Error(`Server error: ${response.status} - ${text}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    console.error('Server Error:', data.error);
                    alert('Error creating category: ' + data.error); // Display error to the user
                    return;
                }

                // Append new category to the select elements
                const categorySelects = document.querySelectorAll('#category, #edit-category');
                categorySelects.forEach(select => {
                    const option = new Option(data.name, data.id);
                    select.add(option);
                });
        
                // Close the modal
                $('#createCategoryModal').modal('hide');
                document.getElementById('createCategoryForm').reset();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error creating category. Please try again.');
            });
        });
    } else {
        console.log('Create Category Form not found.');
    }
});
