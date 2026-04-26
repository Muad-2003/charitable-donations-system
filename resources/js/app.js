import './bootstrap';


document.addEventListener('DOMContentLoaded', () => {
    const loader = document.getElementById('page-loader');

    if (!loader) return;

    // عند الضغط على أي رابط
    document.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            loader.__x.$data.loading = true;
        });
    });

    // عند إرسال أي فورم
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', () => {
            loader.__x.$data.loading = true;
        });
    });
});

