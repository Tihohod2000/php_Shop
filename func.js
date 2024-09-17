document.querySelector('input[type=file]').addEventListener('change', function() {
    let file = this.files[0]; // Получаем выбранный файл

    if (file) {
        let reader = new FileReader(); // Создаем объект FileReader

        // Событие onLoad вызывается, когда файл был полностью загружен
        reader.onload = function(e) {
            let imagePreview = document.getElementById('previewImage'); // Получаем элемент предварительного просмотра изображения
            let imageUpload = document.getElementById('previewImage'); // Получаем элемент предварительного просмотра изображения
            imagePreview.src = e.target.result; // Устанавливаем источник изображения для предварительного просмотра
            imagePreview.style.display = 'block';// Показываем предварительный просмотр изображения
            imageUpload.style.padding = '20px';
        };

        // Читаем файл как URL-адрес данных (Data URL)
        reader.readAsDataURL(file);
    }
});

