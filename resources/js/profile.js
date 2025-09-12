// profile.js
window.openModal = function() {
    document.getElementById('forgotModal').classList.remove('hidden');
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

    // TODO: backend update
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
