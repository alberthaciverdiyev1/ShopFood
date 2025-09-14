// profile.js
window.openModal = function() {
    document.getElementById('forgotModal').classList.remove('hidden');
    let userId = document.getElementById('user_id').value;
    console.log(userId);
    sendForgotPassword(userId);
}

window.closeModal = function() {
    document.getElementById('forgotModal').classList.add('hidden');
}

window.enableEdit = function(button) {
    const container = button.closest('div.relative');
    const input = container.querySelector('input');
    const editBtn = button;
    const saveBtn = container.querySelector('button[title="Save"]');
    const cancelBtn = container.querySelector('button[title="Cancel"]');

    input.removeAttribute('readonly');
    input.classList.remove('bg-gray-100');
    input.focus();

    editBtn.classList.add('hidden');
    saveBtn.classList.remove('hidden');
    cancelBtn.classList.remove('hidden');

    input.dataset.original = input.value;
}

window.saveEdit = function(button) {
    const container = button.closest('div.relative');
    const input = container.querySelector('input');
    const editBtn = container.querySelector('button[title="Edit"]');
    const cancelBtn = container.querySelector('button[title="Cancel"]');

    input.setAttribute('readonly', true);
    input.classList.add('bg-gray-100');

    editBtn.classList.remove('hidden');
    button.classList.add('hidden');
    cancelBtn.classList.add('hidden');

}

window.cancelEdit = function(button) {
    const container = button.closest('div.relative');
    const input = container.querySelector('input');
    const editBtn = container.querySelector('button[title="Edit"]');
    const saveBtn = container.querySelector('button[title="Save"]');

    input.value = input.dataset.original;
    input.setAttribute('readonly', true);
    input.classList.add('bg-gray-100');

    editBtn.classList.remove('hidden');
    saveBtn.classList.add('hidden');
    button.classList.add('hidden');
}

function sendForgotPassword(userId) {
    if(!confirm("Send password reset link to this user?")) return;

    fetch(`/admin/users/forgot-password/${userId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({})
    })
        .then(response => response.json())
        .then(data => {
            if(!data.success) {
                console.error('Error: ' + (data.message || 'Something went wrong'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
