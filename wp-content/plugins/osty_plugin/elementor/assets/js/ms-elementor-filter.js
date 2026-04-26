jQuery(document).ready(function ($) {
    console.log('GO!');
    function updateTemplateOptions(selectedCategory) {
        let templates = msTemplatesData.templates;
        let filteredTemplates = { '0': 'Select a Template' };

        // Если выбрана категория "all", то показываем все шаблоны
        if (selectedCategory === 'all') {
            filteredTemplates = templates;
        } else {
            // Фильтруем шаблоны, оставляя только те, которые относятся к выбранной категории
            $.each(templates, function (templateID, templateName) {
                if (templateID !== '0' && templateName.includes('(' + selectedCategory + ')')) {
                    filteredTemplates[templateID] = templateName;
                }
            });
        }

        // Обновляем список шаблонов в выпадающем списке
        let $templateSelect = $('[data-setting="content_templates"]');
        $templateSelect.empty();

        $.each(filteredTemplates, function (key, value) {
            $templateSelect.append(new Option(value, key));
        });

        $templateSelect.trigger('change');
    }

    // Отслеживаем изменение категории
    $(document).on('change', '[data-setting="template_category"]', function () {
        let selectedCategory = $(this).val();
        updateTemplateOptions(selectedCategory);
    });
});