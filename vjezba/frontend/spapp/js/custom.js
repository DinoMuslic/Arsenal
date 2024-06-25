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
    view : "dashboard",
    load : "dashboard.html",
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
