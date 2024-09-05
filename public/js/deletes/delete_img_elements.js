const element = document.querySelector('.delete');
element.onclick = function () {
    if (confirm('Подтвердите удаление')) {
        send('/delete-product/id' + id);
    } else {
        alert('Удаление отменено');
    }
};
async function send(url) {
    let response = await fetch(url, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    });
    let result = await response.json();
}