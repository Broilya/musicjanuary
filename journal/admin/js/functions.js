/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * general function, usally for data manipulation pages
 *
 * @version $Id$
 */
var DUMP=0;

/**
 * @var sql_box_locked lock for the sqlbox textarea in the querybox/querywindow
 */
var sql_box_locked = false;

/**
 * @var array holds elements which content should only selected once
 */
var only_once_elements = new Array();

/**
 * selects the content of a given object, f.e. a textarea
 *
 * @param   object  element     element of which the content will be selected
 * @param   var     lock        variable which holds the lock for this element
 *                              or true, if no lock exists
 * @param   boolean only_once   if true this is only done once
 *                              f.e. only on first focus
 */
function selectContent( element, lock, only_once ) {
    if ( only_once && only_once_elements[element.name] ) {
        return;
    }

    only_once_elements[element.name] = true;

    if ( lock  ) {
        return;
    }

    element.select();
}

/**
 * Displays an confirmation box before doing some action
 *
 * @param   object   the message to display
 *
 * @return  boolean  whether to run the query or not
 */
function confirmAction(theMessage)
{
    // TODO: Confirmation is not required in the configuration file
    // or browser is Opera (crappy js implementation)
    if (typeof(window.opera) != 'undefined') {
        return true;
    }

    var is_confirmed = confirm(theMessage);

    return is_confirmed;
} // end of the 'confirmAction()' function


// Global variable row_class is set to even
var row_class = 'even';

/**
 * This array is used to remember mark status of rows in browse mode
 */
var marked_row = new Array;
var unique_id='';
var cunique_id = '';


/**
 * enables highlight and marking of rows in data tables
 *
 */
function PMA_markRowsInit() {
    // for every table row ...
    var rows = document.getElementsByTagName('tr');
    for ( var i = 0; i < rows.length; i++ ) {
//alert(i+') length='+rows[i].getElementsByTagName( 'input' ).length);
        // ... with the class 'odd' or 'even' ...

        if ( 'noodd' == rows[i].className.substr(0,5) && 'noeven' != rows[i].className.substr(0,6) ) {
          continue;
        }

        var rows_i_length = rows[i].getElementsByTagName( 'input' ).length;
        if ( 'odd' != rows[i].className.substr(0,3) && 'even' != rows[i].className.substr(0,4) ) {
          if (unique_id == '') continue;

          for ( var j = 0; j < rows_i_length; j++ ) {
            var checkbox = rows[i].getElementsByTagName( 'input' )[j];


if (DUMP) if ( checkbox) {
  alert("#lenght="+rows_i_length+"| "+i+'_'+j+') name='+checkbox.name+'; id='+checkbox.id+'; class='+checkbox.className+'; class='+rows[i].getElementsByTagName( 'input' )[j].className);
}
/*
*/

            if ( checkbox && (checkbox.className == 'butonoff' )){
             unique_id = checkbox.id;
             marked_row[unique_id] = 'butonoff';
          //alert(i+'_'+j+') unique_id='+unique_id+'; v='+marked_row[unique_id]);
            }
          }
            continue;
        }

        // ... add event listeners ...
        // ... to highlight the row on mouseover ...
        if ( navigator.appName == 'Microsoft Internet Explorer' ) {
            // but only for IE, other browsers are handled by :hover in css
            rows[i].onmouseover = function() {
                this.className += ' hover';
            }
            rows[i].onmouseout = function() {
                this.className = this.className.replace( ' hover', '' );
            }
        }
        // Do not set click events if not wanted
        if (rows[i].className.search(/noclick/) != -1) {
            continue;
        }

//        var checkbox = rows[i].getElementsByTagName( 'input' )[rows_i_length-1];

        var chekbox = rows[i].getElementsByTagName( 'input' );
        rows_j_length = chekbox.length;
        for ( var j = 0; j < rows_j_length; j++ ) {
            var checkbox = chekbox[j];
//          var checkbox = rows[i].getElementsByTagName( 'input' )[j];

        
/*              chekbox[j].onmousedown = function(event) {*/
              chekbox[j].onclick= function(event) {
                var checkboxx  = this ;
                cunique_id = '';
                // Somehow IE8 has this not set
                if (!event) var event = window.event;

if (DUMP) {
   alert('~name='+checkboxx.name+'; id='+checkboxx.id+'; class='+checkboxx.className+'; this.id.length='+this.id.length+'; checkboxx.type='+checkboxx.type);
}
              // opera does not recognize return false;
                if ( checkboxx && checkboxx.type == 'checkbox' ) {
                 this.checked = ! this.checked;
                  cunique_id = checkboxx.name + checkboxx.value;
                } else if ( this.id.length > 0 ) {
                  cunique_id = this.id;
                } else {
                    return;
                }
if (DUMP) {
   alert("?lenght="+rows_j_length+"| "+j+') name='+checkboxx.name+'; id='+checkboxx.id+'; class='+checkboxx.className+'; cunique_id='+cunique_id+'; marked_row='+typeof(marked_row[cunique_id])+'='+marked_row[cunique_id]);
}
              }

if (DUMP) if ( checkbox) {
  alert("@lenght="+rows_j_length+"| "+i+'_'+j+') name='+checkbox.name+'; id='+checkbox.id+'; class='+checkbox.className+'; class='+rows[i].className);
}
/*
*/
        // ... and to mark the row on click ...
          if ( checkbox && checkbox.type == 'checkbox' ) {
              unique_id = checkbox.name + checkbox.value;
          } else if ( this.id.length > 0 ) {
              unique_id = this.id;
          } else {
              continue;
          }

if (DUMP) if ( checkbox) {
  alert("@@lenght="+rows_i_length+"| "+i+'_'+j+') name='+checkbox.name+'; id='+checkbox.id+'; class='+checkbox.className+'; unique_id='+unique_id+'; marked_row='+typeof(marked_row[unique_id])+'='+marked_row[unique_id]);
}

          if (rows_i_length-1 > j) continue;

          if ( typeof(marked_row[unique_id]) == 'undefined') {
              marked_row[unique_id] = false;
          }

//        var checkbox = rows[i].getElementsByTagName('input')[rows_i_length-1];
        }  /*  for ( var j  */
/*
        checkbox.onmousedown = function(event) {
            var checkboxx  = this ;
            // Somehow IE8 has this not set
            if (!event) var event = window.event;

if (DUMP) if ( checkboxx) {
    alert("?lenght="+rows_it_length+"| "+it+') name='+checkboxx.name+'; id='+checkboxx.id+'; class='+checkboxx.className+'; class='+this.className);
}
              }
*/



        rows[i].onmousedown = function(event) {
            var checkbox;
            var table;

            // Somehow IE8 has this not set
            if (!event) var event = window.event;

            checkboxes = this.getElementsByTagName( 'input' );
            var rows_it_length = checkboxes.length;

            for (it = 0; it < rows_it_length; it++) {

              checkbox = checkboxes [it];


          
          if ( checkbox ) {
              checkbox.onmousedown = function(event) {
              var checkboxx  = this ;
               cunique_id = '';

              // Somehow IE8 has this not set
              if (!event) var event = window.event;

if (DUMP) {
   alert('~name='+checkboxx.name+'; id='+checkboxx.id+'; class='+checkboxx.className+'; this.id.length='+this.id.length+'; checkboxx.type='+checkboxx.type);
}

              if ( checkboxx && checkboxx.type == 'checkbox' ) {
                this.checked = ! this.checked;
                cunique_id = checkboxx.name + checkboxx.value;
              } else if ( this.id.length > 0 ) {
                cunique_id = this.id;
              } else {
                  return;
              }
if (DUMP) {
   alert("??lenght="+rows_it_length+"| "+it+') name='+checkboxx.name+'; id='+checkboxx.id+'; cunique_id='+cunique_id+'; marked_row='+typeof(marked_row[cunique_id])+'='+marked_row[cunique_id]);
}
                  // opera does not recognize return false;
              }
          }



if (DUMP) if ( checkbox) {
    alert("!lenght="+rows_it_length+"| "+it+') name='+checkbox.name+'; id='+checkbox.id+'; class='+checkbox.className+'; cunique_id='+cunique_id+'; marked_row='+typeof(marked_row[cunique_id])+'='+marked_row[cunique_id]);
}
              if ( checkbox && checkbox.type == 'checkbox' ) {
                  unique_id = checkbox.name + checkbox.value;
              } else if ( this.id.length > 0 ) {
                  unique_id = this.id;
              } else {
                  return;
              }

if (DUMP) if ( checkbox) {
  alert("!!lenght="+rows_i_length+"| "+i+'_'+j+') name='+checkbox.name+'; id='+checkbox.id+'; class='+checkbox.className+'; unique_id='+unique_id+'; marked_row='+typeof(marked_row[unique_id])+'='+marked_row[unique_id]);
}
              if ( typeof(marked_row[unique_id]) == 'undefined') {
                continue ;
              }

              if ((cunique_id != '') && (typeof(marked_row[cunique_id]) == 'undefined')){
                continue;
              }
  
                if ( !marked_row[unique_id] ) {
                    marked_row[unique_id] = true;
                } else {
                    marked_row[unique_id] = false;
                }
if (DUMP) if ( checkbox) {
  alert("!!!lenght="+rows_i_length+"| "+i+'_'+j+') name='+checkbox.name+'; id='+checkbox.id+'; class='+checkbox.className+'; unique_id='+unique_id+'; marked_row='+typeof(marked_row[unique_id])+'='+marked_row[unique_id]);
}
            }

if (DUMP) if ( checkbox) {
  alert("%%lenght="+rows_i_length+"| "+i+'_'+j+') name='+checkbox.name+'; id='+checkbox.id+'; class='+checkbox.className+'; cunique_id='+cunique_id+'; unique_id='+unique_id+'; marked_row='+typeof(marked_row[unique_id])+'='+marked_row[unique_id]);
}

            if ((cunique_id != '') && (typeof(marked_row[cunique_id]) == 'undefined')){
              cunique_id = '';  
              return;
            }

            if ( checkbox && checkbox.disabled == false ) {
              checkbox.checked = marked_row[unique_id];
            }

            if ( marked_row[unique_id] ) {
              this.className += ' marked';
            } else {
              this.className = this.className.replace(' marked', '');
            }
       
if(1)  {
            var off = false;
            var on  = false;
            var unique_key = false;

            for (var key in marked_row) {
              var val = marked_row[key];

if (DUMP) alert('key='+key+'; v='+marked_row[key]);

              if (val == 'butonoff') {
                if (unique_key) {
                   on = true;
                   document.getElementById(key).disabled = (off) ? false : true;
                   if (! off) {
/*                     document.forms[getElementByName('allMark')].elements[getElementByName('allMark')].checked = false;*/
                     for (k=0; k < document.getElementsByName('allMark').length; k++) 
                       document.getElementsByName('allMark')[k].checked = false;
                   }
                   continue;
                } else off = false;
              } else {
                if (on) break;
                else {
                  if (unique_id == key) unique_key = true;

                  if ( off ) continue;

                  if ( val == true ) off = true;
                }
              }
            }
} /*  if (0)  */



if (0)
            if ( checkbox && checkbox.disabled == false ) {
//                checkbox.checked = marked_row[unique_id];
                if (typeof(event) == 'object') {
                    table = this.parentNode;
                    i = 0;
                    while (table.tagName.toLowerCase() != 'table' && i < 20) {
                        i++;
                        table = table.parentNode;
                    }

                    if (event.shiftKey == true && table.lastClicked != undefined) {
                        if (event.preventDefault) { event.preventDefault(); } else { event.returnValue = false; }
                        i = table.lastClicked;

                        if (i < this.rowIndex) {
                            i++;
                        } else {
                            i--;
                        }

                        while (i != this.rowIndex) {
                            table.rows[i].onmousedown();
                            if (i < this.rowIndex) {
                                i++;
                            } else {
                                i--;
                            }
                        }
                    }

                    table.lastClicked = this.rowIndex;
                }
            }
        }  /*  rows[i].onmousedown  */

        // ... and disable label ...
        var rows_i_l_length = rows[i].getElementsByTagName( 'label' ).length;
            rows_i_l_length -= (rows_i_l_length) ? 1 : 0;
        var labeltag = rows[i].getElementsByTagName('label')[rows_i_l_length];
        if ( labeltag ) {
            labeltag.onclick = function() {
                return false;
            }
        }
        // .. and checkbox clicks
    }  /*  for ( var i */

    unique_id='';
}

window.onload=PMA_markRowsInit;

/**
 * Sets/unsets the pointer and marker in browse mode
 *
 * @param   object    the table row
 * @param   integer  the row number
 * @param   string    the action calling this script (over, out or click)
 * @param   string    the default background color
 * @param   string    the color to use for mouseover
 * @param   string    the color to use for marking a row
 *
 * @return  boolean  whether pointer is set or not
 */
function setPointer(theRow, theRowNum, theAction, theDefaultColor, thePointerColor, theMarkColor)
{
    var theCells = null;

    // 1. Pointer and mark feature are disabled or the browser can't get the
    //    row -> exits
    if ((thePointerColor == '' && theMarkColor == '')
        || typeof(theRow.style) == 'undefined') {
        return false;
    }

    // 1.1 Sets the mouse pointer to pointer on mouseover and back to normal otherwise.
    if (theAction == "over" || theAction == "click") {
        theRow.style.cursor='pointer';
    } else {
        theRow.style.cursor='default';
    }

    // 2. Gets the current row and exits if the browser can't get it
    if (typeof(document.getElementsByTagName) != 'undefined') {
        theCells = theRow.getElementsByTagName('td');
    }
    else if (typeof(theRow.cells) != 'undefined') {
        theCells = theRow.cells;
    }
    else {
        return false;
    }

    // 3. Gets the current color...
    var rowCellsCnt  = theCells.length;
    var domDetect    = null;
    var currentColor = null;
    var newColor     = null;
    // 3.1 ... with DOM compatible browsers except Opera that does not return
    //         valid values with "getAttribute"
    if (typeof(window.opera) == 'undefined'
        && typeof(theCells[0].getAttribute) != 'undefined') {
        currentColor = theCells[0].getAttribute('bgcolor');
        domDetect    = true;
    }
    // 3.2 ... with other browsers
    else {
        currentColor = theCells[0].style.backgroundColor;
        domDetect    = false;
    } // end 3

    // 3.3 ... Opera changes colors set via HTML to rgb(r,g,b) format so fix it
    if (currentColor.indexOf("rgb") >= 0)
    {
        var rgbStr = currentColor.slice(currentColor.indexOf('(') + 1,
                                     currentColor.indexOf(')'));
        var rgbValues = rgbStr.split(",");
        currentColor = "#";
        var hexChars = "0123456789ABCDEF";
        for (var i = 0; i < 3; i++)
        {
            var v = rgbValues[i].valueOf();
            currentColor += hexChars.charAt(v/16) + hexChars.charAt(v%16);
        }
    }

    // 4. Defines the new color
    // 4.1 Current color is the default one
    if (currentColor == ''
        || currentColor.toLowerCase() == theDefaultColor.toLowerCase()) {
        if (theAction == 'over' && thePointerColor != '') {
            newColor              = thePointerColor;
        }
        else if (theAction == 'click' && theMarkColor != '') {
            newColor              = theMarkColor;
            marked_row[theRowNum] = true;
            // Garvin: deactivated onclick marking of the checkbox because it's also executed
            // when an action (like edit/delete) on a single item is performed. Then the checkbox
            // would get deactived, even though we need it activated. Maybe there is a way
            // to detect if the row was clicked, and not an item therein...
            // document.getElementById('id_rows_to_delete' + theRowNum).checked = true;
        }
    }
    // 4.1.2 Current color is the pointer one
    else if (currentColor.toLowerCase() == thePointerColor.toLowerCase()
             && (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])) {
        if (theAction == 'out') {
            newColor              = theDefaultColor;
        }
        else if (theAction == 'click' && theMarkColor != '') {
            newColor              = theMarkColor;
            marked_row[theRowNum] = true;
            // document.getElementById('id_rows_to_delete' + theRowNum).checked = true;
        }
    }
    // 4.1.3 Current color is the marker one
    else if (currentColor.toLowerCase() == theMarkColor.toLowerCase()) {
        if (theAction == 'click') {
            newColor              = (thePointerColor != '')
                                  ? thePointerColor
                                  : theDefaultColor;
            marked_row[theRowNum] = (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])
                                  ? true
                                  : null;
            // document.getElementById('id_rows_to_delete' + theRowNum).checked = false;
        }
    } // end 4

    // 5. Sets the new color...
    if (newColor) {
        var c = null;
        // 5.1 ... with DOM compatible browsers except Opera
        if (domDetect) {
            for (c = 0; c < rowCellsCnt; c++) {
                theCells[c].setAttribute('bgcolor', newColor, 0);
            } // end for
        }
        // 5.2 ... with other browsers
        else {
            for (c = 0; c < rowCellsCnt; c++) {
                theCells[c].style.backgroundColor = newColor;
            }
        }
    } // end 5

    return true;
} // end of the 'setPointer()' function

/*
 * Sets/unsets the pointer and marker in vertical browse mode
 *
 * @param   object    the table row
 * @param   integer   the column number
 * @param   string    the action calling this script (over, out or click)
 * @param   string    the default background Class
 * @param   string    the Class to use for mouseover
 * @param   string    the Class to use for marking a row
 *
 * @return  boolean  whether pointer is set or not
 *
 * @author Garvin Hicking <me@supergarv.de> (rewrite of setPointer.)
 */
function setVerticalPointer(theRow, theColNum, theAction, theDefaultClass1, theDefaultClass2, thePointerClass, theMarkClass) {
    // 1. Pointer and mark feature are disabled or the browser can't get the
    //    row -> exits
    if ((thePointerClass == '' && theMarkClass == '')
        || typeof(theRow.style) == 'undefined') {
        return false;
    }

    var tagSwitch = null;

    // 2. Gets the current row and exits if the browser can't get it
    if (typeof(document.getElementsByTagName) != 'undefined') {
        tagSwitch = 'tag';
    } else if (typeof(document.getElementById('table_results')) != 'undefined') {
        tagSwitch = 'cells';
    } else {
        return false;
    }

    var theCells = null;

    if (tagSwitch == 'tag') {
        theRows     = document.getElementById('table_results').getElementsByTagName('tr');
        theCells    = theRows[1].getElementsByTagName('td');
    } else if (tagSwitch == 'cells') {
        theRows     = document.getElementById('table_results').rows;
        theCells    = theRows[1].cells;
    }

    // 3. Gets the current Class...
    var currentClass   = null;
    var newClass       = null;

    // 3.1 ... with DOM compatible browsers except Opera that does not return
    //         valid values with "getAttribute"
    if (typeof(window.opera) == 'undefined'
        && typeof(theCells[theColNum].getAttribute) != 'undefined') {
        currentClass = theCells[theColNum].className;
    } // end 3

    // 4. Defines the new Class
    // 4.1 Current Class is the default one
    if (currentClass == ''
        || currentClass.toLowerCase() == theDefaultClass1.toLowerCase()
        || currentClass.toLowerCase() == theDefaultClass2.toLowerCase()) {
        if (theAction == 'over' && thePointerClass != '') {
            newClass              = thePointerClass;
        } else if (theAction == 'click' && theMarkClass != '') {
            newClass              = theMarkClass;
            marked_row[theColNum] = true;
        }
    }
    // 4.1.2 Current Class is the pointer one
    else if (currentClass.toLowerCase() == thePointerClass.toLowerCase() &&
             (typeof(marked_row[theColNum]) == 'undefined' || !marked_row[theColNum]) || marked_row[theColNum] == false) {
            if (theAction == 'out') {
                if (theColNum % 2) {
                    newClass              = theDefaultClass1;
                } else {
                    newClass              = theDefaultClass2;
                }
            }
            else if (theAction == 'click' && theMarkClass != '') {
                newClass              = theMarkClass;
                marked_row[theColNum] = true;
            }
    }
    // 4.1.3 Current Class is the marker one
    else if (currentClass.toLowerCase() == theMarkClass.toLowerCase()) {
        if (theAction == 'click') {
            newClass              = (thePointerClass != '')
                                  ? thePointerClass
                                  : ((theColNum % 2) ? theDefaultClass2 : theDefaultClass1);
            marked_row[theColNum] = false;
        }
    } // end 4

    // 5 ... with DOM compatible browsers except Opera

    if (newClass) {
        var c = null;
        var rowCnt = theRows.length;
        for (c = 0; c < rowCnt; c++) {
            if (tagSwitch == 'tag') {
                Cells = theRows[c].getElementsByTagName('td');
            } else if (tagSwitch == 'cells') {
                Cells = theRows[c].cells;
            }

            Cell  = Cells[theColNum];

            // 5.1 Sets the new Class...
            Cell.className = Cell.className.replace(currentClass, newClass);
        } // end for
    } // end 5

     return true;
 } // end of the 'setVerticalPointer()' function

/**
 * Checks/unchecks all checkbox in given conainer (f.e. a form, fieldset or div)
 *
 * @param   string   container_id  the container id
 * @param   boolean  state         new value for checkbox (true or false)
 * @return  boolean  always true
 */
function setCheckboxes( container_id, state ) {
    var checkboxes = document.getElementById(container_id).getElementsByTagName('input');

    for ( var i = 0; i < checkboxes.length; i++ ) {
        if ( checkboxes[i].type == 'checkbox' ) {
            checkboxes[i].checked = state;
        }
    }

    return true;
} // end of the 'setCheckboxes()' function


// added 2004-05-08 by Michael Keck <mail_at_michaelkeck_dot_de>
//   copy the checked from left to right or from right to left
//   so it's easier for users to see, if $cfg['ModifyAtRight']=true, what they've checked ;)
function copyCheckboxesRange(the_form, the_name, the_clicked)
{
    if (typeof(document.forms[the_form].elements[the_name]) != 'undefined' && typeof(document.forms[the_form].elements[the_name + 'r']) != 'undefined') {
        if (the_clicked !== 'r') {
            if (document.forms[the_form].elements[the_name].checked == true) {
                document.forms[the_form].elements[the_name + 'r'].checked = true;
            }else {
                document.forms[the_form].elements[the_name + 'r'].checked = false;
            }
        } else if (the_clicked == 'r') {
            if (document.forms[the_form].elements[the_name + 'r'].checked == true) {
                document.forms[the_form].elements[the_name].checked = true;
            }else {
                document.forms[the_form].elements[the_name].checked = false;
            }
       }
    }
}


// added 2004-05-08 by Michael Keck <mail_at_michaelkeck_dot_de>
//  - this was directly written to each td, so why not a function ;)
//  setCheckboxColumn(\'id_rows_to_delete' . $row_no . ''\');
function setCheckboxColumn(theCheckbox){
    if (document.getElementById(theCheckbox)) {
        document.getElementById(theCheckbox).checked = (document.getElementById(theCheckbox).checked ? false : true);
        if (document.getElementById(theCheckbox + 'r')) {
            document.getElementById(theCheckbox + 'r').checked = document.getElementById(theCheckbox).checked;
        }
    } else {
        if (document.getElementById(theCheckbox + 'r')) {
            document.getElementById(theCheckbox + 'r').checked = (document.getElementById(theCheckbox +'r').checked ? false : true);
            if (document.getElementById(theCheckbox)) {
                document.getElementById(theCheckbox).checked = document.getElementById(theCheckbox + 'r').checked;
            }
        }
    }
}


/**
  * Checks/unchecks all options of a <select> element
  *
  * @param   string   the form name
  * @param   string   the element name
  * @param   boolean  whether to check or to uncheck the element
  *
  * @return  boolean  always true
  */
function setSelectOptions(the_form, the_select, do_check)
{
    var selectObject = document.forms[the_form].elements[the_select];
    var selectCount  = selectObject.length;

    for (var i = 0; i < selectCount; i++) {
        selectObject.options[i].selected = do_check;
    } // end for

    return true;
} // end of the 'setSelectOptions()' function

/**
  * Inserts multiple fields.
  *
  */
function insertValueQuery() {
    var myQuery = document.sqlform.sql_query;
    var myListBox = document.sqlform.dummy;

    if(myListBox.options.length > 0) {
        sql_box_locked = true;
        var chaineAj = "";
        var NbSelect = 0;
        for(var i=0; i<myListBox.options.length; i++) {
            if (myListBox.options[i].selected){
                NbSelect++;
                if (NbSelect > 1)
                    chaineAj += ", ";
                chaineAj += myListBox.options[i].value;
            }
        }

        //IE support
        if (document.selection) {
            myQuery.focus();
            sel = document.selection.createRange();
            sel.text = chaineAj;
            document.sqlform.insert.focus();
        }
        //MOZILLA/NETSCAPE support
        else if (document.sqlform.sql_query.selectionStart || document.sqlform.sql_query.selectionStart == "0") {
            var startPos = document.sqlform.sql_query.selectionStart;
            var endPos = document.sqlform.sql_query.selectionEnd;
            var chaineSql = document.sqlform.sql_query.value;

            myQuery.value = chaineSql.substring(0, startPos) + chaineAj + chaineSql.substring(endPos, chaineSql.length);
        } else {
            myQuery.value += chaineAj;
        }
        sql_box_locked = false;
    }
}

/**
  * listbox redirection
  */
function goToUrl(selObj, goToLocation) {
    eval("document.location.href = '" + goToLocation + "pos=" + selObj.options[selObj.selectedIndex].value + "'");
}

/**
 * getElement
 */
function getElement(e,f){
    if(document.layers){
        f=(f)?f:self;
        if(f.document.layers[e]) {
            return f.document.layers[e];
        }
        for(W=0;W<f.document.layers.length;W++) {
            return(getElement(e,f.document.layers[W]));
        }
    }
    if(document.all) {
        return document.all[e];
    }
    return document.getElementById(e);
}

/**
  * Refresh the WYSIWYG-PDF scratchboard after changes have been made
  */
function refreshDragOption(e) {
    myid = getElement(e);
    if (myid.style.visibility == 'visible') {
        refreshLayout();
    }
}

/**
  * Refresh/resize the WYSIWYG-PDF scratchboard
  */
function refreshLayout() {
        myid = getElement('pdflayout');

        if (document.pdfoptions.orientation.value == 'P') {
            posa = 'x';
            posb = 'y';
        } else {
            posa = 'y';
            posb = 'x';
        }

//        myid.style.width = pdfPaperSize(document.pdfoptions.paper.value, posa) + 'px';
//        myid.style.height = pdfPaperSize(document.pdfoptions.paper.value, posb) + 'px';
}


/**
 * rajk - for playing media from the BLOB repository
 *
 * @param   var     
 * @param   var     url_params  main purpose is to pass the token 
 * @param   var     bs_ref      BLOB repository reference
 * @param   var     m_type      type of BLOB repository media
 * @param   var     w_width     width of popup window
 * @param   var     w_height    height of popup window
 */
function popupBSMedia(url_params, bs_ref, m_type, is_cust_type, w_width, w_height)
{
    // if width not specified, use default
    if (w_width == undefined)
        w_width = 640;

    // if height not specified, use default
    if (w_height == undefined)
        w_height = 480;

    // open popup window (for displaying video/playing audio)
    var mediaWin = window.open('bs_play_media.php?' + url_params + '&bs_reference=' + bs_ref + '&media_type=' + m_type + '&custom_type=' + is_cust_type, 'viewBSMedia', 'width=' + w_width + ', height=' + w_height + ', resizable=1, scrollbars=1, status=0');
}
/**
 * Changes the image on hover effects
 *
 * @param   img_obj   the image object whose source needs to be changed
 *
 */
 
function change_Image(img_obj)
{
    var relative_path = (img_obj.src).split("themes/"); 
    
    if (relative_path[1] == 'original/img/new_data.jpg') {    
        img_obj.src = "./themes/original/img/new_data_hovered.jpg";  
    } else if (relative_path[1] == 'original/img/new_struct.jpg') {
        img_obj.src = "./themes/original/img/new_struct_hovered.jpg";
    } else if (relative_path[1] == 'original/img/new_struct_hovered.jpg') {
        img_obj.src = "./themes/original/img/new_struct.jpg";
    } else if (relative_path[1] == 'original/img/new_data_hovered.jpg') {    
        img_obj.src = "./themes/original/img/new_data.jpg";  
    } else if (relative_path[1] == 'original/img/new_data_selected.jpg') {    
        img_obj.src = "./themes/original/img/new_data_selected_hovered.jpg";  
    } else if(relative_path[1] == 'original/img/new_struct_selected.jpg') {    
        img_obj.src = "./themes/original/img/new_struct_selected_hovered.jpg";  
    } else if (relative_path[1] == 'original/img/new_struct_selected_hovered.jpg') {    
        img_obj.src = "./themes/original/img/new_struct_selected.jpg";  
    } else if (relative_path[1] == 'original/img/new_data_selected_hovered.jpg') {    
        img_obj.src = "./themes/original/img/new_data_selected.jpg";  
    }
}

/**
 * Check if a form's element is empty
 * should be
 *
 * @param   object   the form
 * @param   string   the name of the form field to put the focus on
 *
 * @return  boolean  whether the form field is empty or not
 */
function emptyCheckTheField(theForm, theFieldName)
{
    var isEmpty  = 1;
    var theField = theForm.elements[theFieldName];
    // Whether the replace function (js1.2) is supported or not
    var isRegExp = (typeof(theField.value.replace) != 'undefined');

    if (!isRegExp) {
        isEmpty      = (theField.value == '') ? 1 : 0;
    } else {
        var space_re = new RegExp('\\s+');
        isEmpty      = (theField.value.replace(space_re, '') == '') ? 1 : 0;
    }

    return isEmpty;
} // end of the 'emptyCheckTheField()' function


/**
 *
 * @param   object   the form
 * @param   string   the name of the form field to put the focus on
 *
 * @return  boolean  whether the form field is empty or not
 */
function emptyFormElements(theForm, theFieldName)
{
    var theField = theForm.elements[theFieldName];
    var isEmpty = emptyCheckTheField(theForm, theFieldName);


    return isEmpty;
} // end of the 'emptyFormElements()' function


/**
 * Ensures a value submitted in a form is numeric and is in a range
 *
 * @param   object   the form
 * @param   string   the name of the form field to check
 * @param   integer  the minimum authorized value
 * @param   integer  the maximum authorized value
 *
 * @return  boolean  whether a valid number has been submitted or not
 */
function checkFormElementInRange(theForm, theFieldName, message, min, max)
{
    var theField         = theForm.elements[theFieldName];
    var val              = parseInt(theField.value);

    if (typeof(min) == 'undefined') {
        min = 0;
    }
    if (typeof(max) == 'undefined') {
        max = Number.MAX_VALUE;
    }

    // It's not a number
    if (isNaN(val)) {
        theField.select();
        alert(PMA_messages['strNotNumber']);
        theField.focus();
        return false;
    }
    // It's a number but it is not between min and max
    else if (val < min || val > max) {
        theField.select();
        alert(message.replace('%d', val));
        theField.focus();
        return false;
    }
    // It's a valid number
    else {
        theField.value = val;
    }
    return true;

} // end of the 'checkFormElementInRange()' function

/**
 * marks all rows and selects its first checkbox inside the given element
 * the given element is usaly a table or a div containing the table or tables
 *
 * @param    container    DOM element
 */
function markAllRows( container_id ) {
    var rows = document.getElementById(container_id).getElementsByTagName('tr');
    var unique_id;
    var checkbox;

    for ( var i = 0; i < rows.length; i++ ) {
if (DUMP)  {
  alert("#lenght="+rows.length+"| "+i+') rows[i].getElementsByTagName( input ).lenght='+rows[i].getElementsByTagName( 'input' ).length);
}
      if (rows[i].getElementsByTagName( 'input' ).lenght == 0)
        continue;

      if ( 'odd' != rows[i].className.substr(0,3) && 'even' != rows[i].className.substr(0,4) ) {
        for ( var j = 0; j < rows[i].getElementsByTagName( 'input' ).length; j++ ) {
          checkbox = rows[i].getElementsByTagName( 'input' )[j];

if (DUMP) if ( checkbox) {
  alert("#lenght="+rows.length+"| "+i+'_'+j+') name='+checkbox.name+'; id='+checkbox.id+'; class='+checkbox.className+'; class='+rows[i].getElementsByTagName( 'input' )[j].className);
}
          if ( checkbox && checkbox.className == 'butonoff' ) {
             checkbox.disabled = false;
          }
        }
        continue;
      }

        j= rows[i].getElementsByTagName( 'input' ).length-1;
        checkbox = rows[i].getElementsByTagName( 'input' )[j];

if (DUMP) if ( checkbox) {
  alert("#lenght="+rows.length+"| "+i+'_'+j+') name='+checkbox.name+'; id='+checkbox.id+'; class='+checkbox.className+'; class='+rows[i].getElementsByTagName( 'input' )[j].className);
}

/*alert(i+'_'+j+'='+rows[i].getElementsByTagName( 'input' )[j]);*/

        if ( checkbox && checkbox.type == 'checkbox' ) {
           unique_id = checkbox.name + checkbox.value;
           if ( checkbox.disabled == false ) {
              checkbox.checked = true;
              if ( typeof(marked_row[unique_id]) == 'undefined' || !marked_row[unique_id] ) {
                 rows[i].className += ' marked';
                 marked_row[unique_id] = true;
              }
           }
        }

    }

    return true;
}

/**
 * marks all rows and selects its first checkbox inside the given element
 * the given element is usaly a table or a div containing the table or tables
 *
 * @param    container    DOM element
 */
function unMarkAllRows( container_id ) {
    var rows = document.getElementById(container_id).getElementsByTagName('tr');
    var unique_id;
    var checkbox;

    for ( var i = 0; i < rows.length; i++ ) {

if (DUMP) {
  alert("#lenght="+rows.length+"| "+i+') rows[i].getElementsByTagName( input ).lenght='+rows[i].getElementsByTagName( 'input' ).length);
}
      if (rows[i].getElementsByTagName( 'input' ).lenght == 0)
        continue;

      if ( 'odd' != rows[i].className.substr(0,3) && 'even' != rows[i].className.substr(0,4) ) {
        for ( var j = 0; j < rows[i].getElementsByTagName( 'input' ).length; j++ ) {
          checkbox = rows[i].getElementsByTagName( 'input' )[j];
if (DUMP) if ( checkbox) {
  alert("#lenght="+rows.length+"| "+i+'_'+j+') name='+checkbox.name+'; id='+checkbox.id+'; class='+checkbox.className+'; class='+rows[i].getElementsByTagName( 'input' )[j].className);
}
          if ( checkbox && checkbox.className == 'butonoff' ) {
             checkbox.disabled = true;
          }
        }
        continue;
      }

        j= rows[i].getElementsByTagName( 'input' ).length-1;
        checkbox = rows[i].getElementsByTagName( 'input' )[j];

if (DUMP) if ( checkbox) {
  alert("#lenght="+rows.length+"| "+i+'_'+j+') name='+checkbox.name+'; id='+checkbox.id+'; class='+checkbox.className+'; class='+rows[i].getElementsByTagName( 'input' )[j].className);
}

/*alert(i+'_'+j+'='+rows[i].getElementsByTagName( 'input' )[j]);*/

        if ( checkbox && checkbox.type == 'checkbox' ) {
           unique_id = checkbox.name + checkbox.value;
           checkbox.checked = false;
           rows[i].className = rows[i].className.replace(' marked', '');
           marked_row[unique_id] = false;
/*            if (typeof(var) == "undefined") { ... }*/
        }

    }

    return true;
}


