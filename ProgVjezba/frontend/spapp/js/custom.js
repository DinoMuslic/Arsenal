$(document).ready(function() {

  $("main#spapp > section").height($(document).height() - 60);


  var app = $.spapp({
    defaultView  : "#home",
    templateDir  : "./pages/",
    pageNotFound : "#404"
  });
  
  app.route({
    view : "home",
    load : "home.html",
    onCreate: function() {  },
    onReady: function() {  }
  });

  app.route({
    view : "login",
    load : "login.html",
    onCreate: function() {  },
    onReady: function() {  }
  });

  app.route({
    view : "register",
    load : "register.html",
    onCreate: function() {  },
    onReady: function() {  }
  });

  app.route({
    view : "admin",
    load : "admin.html",
    onCreate: function() {  },
    onReady: function() {  }
  });

  app.route({
    view : "404",
    load : "404.html",
    onCreate: function() {  },
    onReady: function() {  }
  });

  app.run();
});
