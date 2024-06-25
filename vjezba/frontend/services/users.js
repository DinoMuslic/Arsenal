var UserService = {
    reload_users_datatable: function () {
      Utils.get_datatable(
        "tbl_users",
        Constants.get_api_base_url() + "backend/users",
        [
          { data: "id" },
          { data: "first_name" },
          { data: "last_name" },
          { data: "email" },
          { data: "action" }
        ],
      );
    },

    reload_users_datatable2: function (letter) {
      Utils.get_datatable(
        "tbl_users2",
        Constants.get_api_base_url() + "backend/users/" + letter,
        [
          { data: "id" },
          { data: "first_name" },
          { data: "last_name" },
          { data: "email" },
          //{ data: "action" }
        ],
      );
    },

    open_edit_user_modal : function(user_id) {
        RestClient.get(
          'backend/users/get/' + user_id,
          function(data) {
            $('#add-user-modal').modal("toggle");
            $("#add-user-form input[name='id']").val(data.id);
            $("#add-user-form input[name='first_name']").val(data.first_name);
            $("#add-user-form input[name='last_name']").val(data.last_name);
            $("#add-user-form input[name='email']").val(data.email);
          }
        )
    },

    delete_user : function(user_id) {
      if(confirm("Do you really want to delete this user?")) {
        RestClient.delete(
          "backend/users/delete/" + user_id,
          {},
          function(data) {
            console.log("user deleted successfully");
            UserService.reload_users_datatable();
        });
      }
    },
}