function slide_overview( x, id = 0 ) {
  m = m+x;

  if ( id == -1 ) user_id = 0;
  else if ( id == user_id ) user_id = 0;
  else if ( id != 0 ) user_id = id;

  if ( m < 1 ) { m = 12; y = y-1; }
  if ( m > 12 ) { m = 1; y = y+1; }

  $(".person").css("background-color", "");
  if (user_id != 0) $(".person"+user_id).css("background-color", "#DBD8D8");

  $("#overview_table").html("<div class='title'>Počkajte prosím...</div><div class='loader'><span class='fa fa-spinner fa-pulse fa-3x fa-fw'></span></div>");
  setTimeout(function(){ $("#overview_table").load("ajax/load_overview_table.php?y=" + y + "&m=" + m + "&id=" + user_id); }, 500);
}

function remove_record( id, date, name ) {
  if ( confirm("Vymazať záznam: " + name + " (" + date + ") ?") ) {
    $(".box" + date + " .value" + id).load("ajax/remove_record.php?id=" + id + "&date=" + date);
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
