var FormValidation = {
    serialize_form : function (form) {
      let result = {};
      $.each($(form).serializeArray(), function () {
          result[this.name] = this.value;
      });
      return result;
    },
}

