$(function () {
    var en = {
        required: "This field is required.",
        remote: "Please fix this field.",
        email: "Please enter a valid email address.",
        url: "Please enter a valid URL.",
        date: "Please enter a valid date.",
        dateISO: "Please enter a valid date (ISO).",
        number: "Please enter a valid number.",
        digits: "Please enter only digits.",
        creditcard: "Please enter a valid credit card number.",
        equalTo: "Please enter the same value again.",
        accept: "Please enter a value with a valid extension.",
        maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
        minlength: jQuery.validator.format("Please enter at least {0} characters."),
        rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
        range: jQuery.validator.format("Please enter a value between {0} and {1}."),
        max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
        min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
    }

    var ja = {
    	required: "このフィールドは必須です。",
    	remote: "このフィールドを修正してください。",
    	email: "有効なEメールアドレスを入力してください。",
    	url: "有効なURLを入力してください。",
    	date: "有効な日付を入力してください。",
    	dateISO: "有効な日付（ISO）を入力してください。",
    	number: "有効な数字を入力してください。",
    	digits: "数字のみを入力してください。",
    	creditcard: "有効なクレジットカード番号を入力してください。",
    	equalTo: "同じ値をもう一度入力してください。",
    	extension: "有効な拡張子を含む値を入力してください。",
    	maxlength: $.validator.format( "{0} 文字以内で入力してください。" ),
    	minlength: $.validator.format( "{0} 文字以上で入力してください。" ),
    	rangelength: $.validator.format( "{0} 文字から {1} 文字までの値を入力してください。" ),
    	range: $.validator.format( "{0} から {1} までの値を入力してください。" ),
    	step: $.validator.format( "{0} の倍数を入力してください。" ),
    	max: $.validator.format( "{0} 以下の値を入力してください。" ),
    	min: $.validator.format( "{0} 以上の値を入力してください。" )
    }

    switch ($('html').attr('lang')) {
        case 'en':
            $.extend($.validator.messages, en);
            langDataTable = 'en.json';
            langCKeditor4 = 'en';
            break;
        case 'ja':
            $.extend($.validator.messages, ja);
            langDataTable = 'ja.json';
            langCKeditor4 = 'ja';
            break;
        default:
        $.extend($.validator.messages, en);

    }

});
