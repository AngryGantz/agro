/*
 * Translated default messages for the jQuery validation plugin.
 * Locale: RU (Russian; русский язык)
 */
(function($) {
	$.extend($.validator.messages, {
		required: "Заполнять обязательно",
		remote: "Введите правильное значение",
		email: "Введите корректный адрес электронной почты",
		url: "Введите корректный URL",
		date: "Введите корректную дату",
		dateISO: "Введите корректную дату в формате ISO",
		number: "Допустимы только числа",
		digits: "Допустимы только цифры",
		creditcard: "Введите правильный номер кредитной карты",
		equalTo: "Введите такое же значение ещё раз",
		extension: "Выберите файл с разрешенным расширением",
		maxlength: $.validator.format("Не более {0} символов"),
		minlength: $.validator.format("Не менее {0} символов"),
		rangelength: $.validator.format("Введите значение длиной от {0} до {1} символов"),
		range: $.validator.format("Введите число от {0} до {1}"),
		max: $.validator.format("Введите число, меньшее или равное {0}"),
		min: $.validator.format("Введите число, большее или равное {0}")
	});
}(jQuery));
