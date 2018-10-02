function resetpass( x ) {
  if ( x == 1 ) {
    $("#lost_pass_form").toggle();
  }
  if ( x == 2 ) {
    var email = $("#lost_password").val();
    $.post( 'ajax/reset_pass.php', { email: email })
      .done(function( data ) {
        $('#lost_pass_form').html(data);
      });
  }
}

function user_switch( y, m, personal_id ) {
  reload_calndar(y, m, personal_id.value);
}

function terms_set( year ) {
  var m1 = $("input[name='m1']").val();
  var m2 = $("input[name='m2']").val();
  var m3 = $("input[name='m3']").val();
  var m4 = $("input[name='m4']").val();
  var m5 = $("input[name='m5']").val();
  var m6 = $("input[name='m6']").val();
  var m7 = $("input[name='m7']").val();
  var m8 = $("input[name='m8']").val();
  var m9 = $("input[name='m9']").val();
  var m10 = $("input[name='m10']").val();
  var m11 = $("input[name='m11']").val();
  var m12 = $("input[name='m12']").val();

  $.post( 'ajax/terms_set.php?year=' + year, { m1: m1, m2: m2, m3: m3, m4: m4, m5: m5, m6: m6, m7: m7, m8: m8, m9: m9, m10: m10, m11: m11, m12: m12 })
    .done(function( data ) {
      $('#info_container').html(data);
    });
}

function calendar_add( year, month, personal_id = 0 ) {
  $.post( 'ajax/calendar_set.php?year=' + year + '&month=' + month, { d1: date1, d2: date2, personal_id: personal_id })
    .done(function( data ) {
      $('#calendar').html(data);
    });
}

var date1 = 0;
var date2 = 0;

function calendar_click( n ) {
  if ( date1 == 0 && !$(".day_"+n).is(".absence, .weekend, .holiday") )
    date1 = n;
  else if ( date2 == 0 && n != date1 && !$(".day_"+n).is(".weekend, .absence, .holiday") )
    date2 = n;
  else
    date1 = date2 = 0;

  $(".button_submit").css("display", "none");
  if ( date1 && date2 )
    $("#multiple_add").css("display", "inline-block");
  else if ( date1 )
    $("#single_add").css("display", "inline-block");
  else
    $("#empty_add").css("display", "inline-block");

  if ( date2 < date1 && date2 != 0 ) {
    var cache = date2;
    date2 = date1;
    date1 = cache;
  }

  $("td.week").css("background-color", "#DDD");
  for ( var i = date1 ; (i <= date2 && date2 != 0) || i == date1 ; i++ )
    $("td.week.day_"+i).css("background-color", "#CF7673");

}

function calendar_set(y, m, date1, date2, personal_id = 0) {
  var time_type = $("input[name='c_time_type']:checked").val();
  var from_h = $("input[name='c_from_h']").val();
  var from_m = $("input[name='c_from_m']").val();
  var to_h = $("input[name='c_to_h']").val();
  var to_m = $("input[name='c_to_m']").val();
  var is_public = $("input[name='c_public']:checked").val();
  var type = $("input[name='c_type']:checked").val();
  var description = $("input[name='c_description']").val();

  $.post( "ajax/calendar_set.php?year=" + y + "&month=" + m, {
      d1: date1,
      d2: date2,
      time_type: time_type,
      from_h: from_h,
      from_m: from_m,
      to_h: to_h,
      to_m: to_m,
      is_public: is_public,
      type: type,
      description: description,
      personal_id: personal_id
    })
    .done(function( data ) { $('#calendar').html(data); }
  );
}

function request_set ( id ) {
  $.post("ajax/request_set.php", { id: id })
    .done( function(data){
      if ( data == "OK1" ) {
        $("#request_check_" + id).removeClass("disable");
        $("#request_check_" + id).addClass("enable");
      }
      if ( data == "OK2" ) {
        $("#request_check_" + id).removeClass("enable");
        $("#request_check_" + id).addClass("disable");
      }
    } );
}

function events_load( year ){
  $("#events_table").html("<div class='loader'><span class='fa fa-spinner fa-pulse fa-3x fa-fw'></span></div>");
  $("#events_table").load("ajax/events_load.php?year=" + year);
}

function event_add( year ){
  var description = $("input[name='description']").val();
  var day = $("input[name='day']").val();
  var month = $("input[name='month']").val();

  $.post("ajax/event_add.php?year=" + year, { description: description, day: day, month: month })
    .done( function(data){
      $("#info_container").html(data);
      events_load( year );

      $("input[name='description']").val("");
      $("input[name='day']").val("");
      $("input[name='month']").val("");
    } );
}

function event_remove( id ){
  $.post("ajax/event_remove.php", { id: id })
    .done( function(data){
      if ( data == "OK" )
        $("#event_" + id).css("opacity", "0.2");
    } );
}

function hidder( obj ) {
  $(obj).show().fadeOut();
}

function user_edit( p_id = 0 ) {
  var holidays_budget = $("input[name='holidays_budget']").val();
  var personal_id = $("input[name='personal_id']").val();
  var name = $("input[name='name']").val();
  var surname = $("input[name='surname']").val();
  var email = $("input[name='email']").val();
  var username = $("input[name='username']").val();
  var password = $("input[name='password']").val();
  var status = $("input[name='status']:checked").val();

  $.post("ajax/user_edit.php?personal_id=" + p_id, {
      holidays_budget: holidays_budget,
      personal_id: personal_id,
      name: name,
      surname: surname,
      email: email,
      username: username,
      password: password,
      status: status
    })
    .done( function(data){
      $("#info_container").html(data);
    } );
}

function profile_edit() {
  var username = $("input[name='username']").val();
  var email = $("input[name='email']").val();
  var password_new_1 = $("input[name='password_new_1']").val();
  var password_new_2 = $("input[name='password_new_2']").val();
  var password = $("input[name='password']").val();

  $.post("ajax/profile_edit.php", {username: username, email: email, password_new_1: password_new_1, password_new_2: password_new_2, password: password})
    .done( function(data){
      $("#info_container").html(data);
    } );
}

function holiday_paper(button, _personal_id, _year, _from, _to, _num, _request_date){
  $(button).attr("disabled", "disabled");
  $(button).parent().children('.message').remove();
  $(button).parent().append("<div class='message print info'>Pripravuje sa…</div>");
  $.post( "ajax/print_holiday_request.php",
    { personal_id: _personal_id,
      year: _year, from_time: _from, to_time: _to, num_of_days: _num,
      request_date: _request_date }
    ).done( function( data ) {
      $(button).parent().children('.message').remove();
      $(button).parent().append("<div class='message print info'>Lístok bol odoslaný na tlačiareň "
        + "<small>(" + data + ")</small>"
        + "</div>");
      $(button).removeAttr("disabled");
      $(button).html("Vytlačiť znova")
    }
  ).fail( function( jqXHR ) {
      $(button).parent().children('.message').remove();
      $(button).parent().append("<div class='message print error'>Chyba pri tlači, kontaktujte správcu"
        + "<pre>" + jqXHR.responseText + "</pre>"
        + "</div>");
      $(button).removeAttr("disabled");
      $(button).html("Vytlačiť znova")
    }
  );
}

function show_time() {
  show( "input[name='c_time_type']", 2, ".input_time" );
}

function show_subtypes() {
  show( "input[name='c_type']", 8, ".input_subtype" );
}

function show( input, value, output ) {
  if ( $( input+":checked" ).val() == value ) {
    $(output).css("max-height", "2000px");
  }
  else {
    $(output).css("max-height", "0px");
  }
}

function reload_calndar(y, m, personal_id = 0) {
  if ( $("#calendar")[0] )
    $("#calendar").html("<div class='loader'><span class='fa fa-spinner fa-pulse fa-3x fa-fw'></span></div>");
    var id = "";
    if ( personal_id > 0 ) id = "&personal_id=" + personal_id;
    $("#calendar").load("ajax/calendar_load.php?year="+y+"&month="+m+id);
};

function overview_set_user ( id ) {
  if ( id == -1 ) user_id = 0;
  else if ( id == user_id ) user_id = 0;
  else if ( id != 0 ) user_id = id;

  slide_overview( y, m, user_id, 1 );
}

function slide_overview( year, month, id = 0, title = 1, personal_id = 0 ) {
  if ( id != 0 ) user_id = id;
  y = year;
  m = month;

  $(".person").css("background-color", "");
  if (user_id != 0) $("#person_"+user_id).css("background-color", "#DBD8D8");

  $("#overview_table").html("<div class='title'>Počkajte prosím...</div><div class='loader'><span class='fa fa-spinner fa-pulse fa-3x fa-fw'></span></div>");
  $("#overview_table").load("ajax/overview_load.php?year=" + year + "&month=" + month + "&p_id=" + user_id + "&title=" + title + "&personal_id=" + personal_id);
}

function overview_remove_value( id, full_name ) {
  if ( confirm("Vymazať záznam: " + full_name + " ?") ) {
    $.post( "ajax/overview_remove_value.php", { absence_id: id })
      .done( function( data ) {
          $(".value_" + id + " .name").html(data);
      }
    );
  }
}

function edit_profile( p_id ) {
  var arr = [ $("#p_title").val(), $("#p_username").val(), $("#p_email").val(), $("#p_password_new_1").val(), $("#p_password_new_2").val(), $("#p_password").val() ];

  $.post( "ajax/edit_profile.php", { p_id: p_id, title: arr[0], username: arr[1], email: arr[2], password_new_1: arr[3], password_new_2: arr[4], password: arr[5] })
    .done( function( data ) {
      alert( "Data Loaded: " + data );
    }
  );
}
