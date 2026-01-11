var arrLang = {
    "en-gb": {
      "units": "units",
      "register_minor_unit": "register_minor_unit",
      "registered_minor_units": "registered_minor_units ",
      "register_major_unit": "register_major_unit",
      "registered_major_units": "registered_major_units",
      "fa": "persian",
      "en-gb": "English",
      "language": "languages",
      "customers": "customers",
      "register_customer": "register_customer",
      "registered_customers": "registered_customers",
      "customers_billance": "customers_billance",
      "expenses": "expenses",
      "register_expense": "register_expense",
      "registered_expenses": "registered_expenses",
      "register_expense_category": "register_expense_category",
      "registered_expenses_category": "registered_expenses_category",
      "items": "items",
      "register_exist_good": "register_exist_good",
      "stock_minor_units": "stock_minor_units",
      "register_good": "register_good",
      "registered_goods": "registered_goods",
      "suppliers": "suppliers",
      "register_supplier": "register_supplier",
      "registered_suppliers": "registered_suppliers",
      "suppliers_billance": "suppliers_billance",
      "employees": "employees",
      "register_employee": "register_employee",
      "registered_employees": "registered_employees",
      "register_user": "register_user",
      "registered_users": "registered_users",
      "purchase": "purchase",
      "purchase_invoice": "purchase_invoice",
      "purchased_items": "purchased_items",
      "sales": "sales",
      "page-invoice": "page-invoice",
      "selled_page": "selled_page",
      "main-page": "main-page",
      "": "",
    },
    "fa": {
      "units": "واحدات",
      "register_minor_unit": "ثبت (واحد فرعی)",
      "registered_minor_units": "نمایش (واحدات فرعی)",
      "register_major_unit": "ثبت (واحد اصلی)",
      "registered_major_units": "نمایش (واحدات اصلی)",
      "fa": "فارسی",
      "en-gb": "انگلیسی",
      "language": "زبان",
      "customers": "مشتریان",
      "register_customer": "ثبت (مشتری)",
      "registered_customers": "نمایش (مشتریان)",
      "customers_billance": "بیلانس (مشتریان دایمی)",
      "expenses": "مصارف",
      "register_expense": "ثبت (مصرف)",
      "registered_expenses": "نمایش (مصارف)",
      "register_expense_category": "ثبت کتگوری(مصرف)",
      "registered_expenses_category": "نمایش کتگوری(مصارف)",
      "items": "جنس ها",
      "register_exist_good": "ثبت جنس موجودی",
      "stock_minor_units": "نمایش گدام",
      "register_good": "ثبت جنس",
      "registered_goods": "نمایش جنس ها",
      "suppliers": "تمویل کننده ها",
      "register_supplier": "ثبت (تمویل کننده ها)",
      "registered_suppliers": "نمایش (تمویل کننده ها)",
      "suppliers_billance": "بیلانس (تمویل کننده ها)",
      "employees": "کارمندان",
      "register_employee": "ثبت (کارمند)",
      "registered_employees": "نمایش (کارمند)",
      "register_user": "ثبت (کاربر)",
      "registered_users": "نمایش (کاربر)",
      "purchase": "خرید",
      "purchase_invoice": "ثبت (خرید)",
      "purchased_items": "نمایش (خرید ها)",
      "sales": "فروشات",
      "page-invoice": "ثبت (فروش)",
      "selled_page": "نمایش (فروشات)",
      "main-page": "صفحه اصلی",
      "": "",
    }
  };

  $(document).ready(function() {
    // The default language is English
    var lang = localStorage.getItem('language_key') != "" ? localStorage.getItem('language_key') : "fa";
    $(".lang").each(function(index, element) {
      $(this).text(arrLang[lang][$(this).attr("key")]);
    });
  });

  // get/set the selected language
  $(".translate").click(function() {
    var lang = $(this).attr("id");
    localStorage.setItem('language_key',lang);
    $(".lang").each(function(index, element) {
      $(this).text(arrLang[lang][$(this).attr("key")]);
    });
  });
