document.addEventListener('DOMContentLoaded', function() {
    // Handle edit button click
    const editButtons = document.querySelectorAll('.edit-button');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const quantity = this.getAttribute('data-quantity');
            const categoryId = this.getAttribute('data-category');

            document.getElementById('product-id').value = id;
            document.getElementById('edit-product-name').value = name;
            document.getElementById('edit-quantity').value = quantity;

            // Pre-select the category
            const categorySelect = document.getElementById('edit-category');
            categorySelect.value = categoryId;

            document.getElementById('edit-form-container').style.display = 'block';
        });
    });

    // Handle new category creation
    document.getElementById('createCategoryForm').addEventListener('submit', function(e) {
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
                return;
            }
            // Append new category to the select elements
            const categorySelects = document.querySelectorAll('#category, #edit-category');
            categorySelects.forEach(select => {
                const option = new Option(data.name, data.id);
                select.add(option);
            });
    
            // Close modal
            $('#createCategoryModal').modal('hide');
            document.getElementById('createCategoryForm').reset();
        })
        .catch(error => console.error('Error:', error));
    });
    
});
