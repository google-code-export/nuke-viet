if( typeof( nv_siteroot ) == 'undefined' )
{
   var nv_siteroot = '/';
}

// -----------------------

if( typeof( nv_sitelang ) == 'undefined' )
{
   var nv_sitelang = 'en';
}

// -----------------------

if( typeof( nv_name_variable ) == 'undefined' )
{
   var nv_name_variable = 'nv';
}

// -----------------------

if( typeof( nv_fc_variable ) == 'undefined' )
{
   var nv_fc_variable = 'op';
}

// -----------------------

if( typeof( nv_lang_variable ) == 'undefined' )
{
   var nv_lang_variable = 'language';
}

// -----------------------

if( typeof( nv_module_name ) == 'undefined' )
{
   var nv_module_name = '';
}

if( typeof( nv_area_admin ) == 'undefined' )
{
   var nv_area_admin = 0;
}

// -----------------------

if( typeof( nv_my_ofs ) == 'undefined' )
{
   var nv_my_ofs = 7;
}

// -----------------------

if( typeof( nv_my_dst ) == 'undefined' )
{
   var nv_my_dst = false;
}

// -----------------------

if( typeof( nv_my_abbr ) == 'undefined' )
{
   var nv_my_abbr = 'ICT';
}

// -----------------------

if( typeof( nv_cookie_prefix ) == 'undefined' )
{
   var nv_cookie_prefix = 'nv3';
}

// ---------------------------------------

var OP = ( navigator.userAgent.indexOf( 'Opera' ) != - 1 );
var IE = ( navigator.userAgent.indexOf( 'MSIE' ) != - 1 && ! OP );
var GK = ( navigator.userAgent.indexOf( 'Gecko' ) != - 1 );
var SA = ( navigator.userAgent.indexOf( 'Safari' ) != - 1 );
var DOM = document.getElementById;
var NS4 = document.layers;

var nv_mailfilter  = /^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,6}$/;
var nv_numcheck = /^([0-9])+$/;
var nv_namecheck = /^([a-zA-Z0-9_-])+$/;
var nv_md5check = /^[a-z0-9]{32}$/;
var nv_imgexts = /^.+\.(jpg|gif|png|bmp)$/;
var nv_iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?";
var nv_specialchars = /\$|,|@|#|~|`|\%|\*|\^|\&|\(|\)|\+|\=|\[|\-|\_|\]|\[|\}|\{|\;|\:|\'|\"|\<|\>|\?|\||\\|\!|\$|\./g

var nv_old_Minute = - 1;

var strHref = window.location.href;
if( strHref.indexOf( "?" ) > - 1 )
{
   var strHref_split = strHref.split( "?" );
   var script_name = strHref_split[0];
   var query_string = strHref_split[1];
}

// -----------------------

else
{
   var script_name = strHref;
   var query_string = '';
}

// -----------------------

function nv_email_check( field_id )
{
   return ( field_id.value.length >= 7 && nv_mailfilter.test( field_id.value ) ) ? true : false;
}

// -----------------------

function nv_num_check( field_id )
{
   return ( field_id.value.length >= 1 && nv_numcheck.test( field_id.value ) ) ? true : false;
}

// -----------------------

function nv_name_check(field_id)
{
   return ( field_id.value != '' && nv_namecheck.test( field_id.value ) ) ? true : false;
}

// -----------------------

function nv_md5_check(field_id)
{
   return ( nv_md5check.test( field_id.value ) ) ? true : false;
}

// -----------------------

function nv_iChars_check(field_id)
{
   for (var i = 0; i < field_id.value.length;
   i ++ )
   {
      if (nv_iChars.indexOf(field_id.value.charAt(i)) != - 1)
      {
         return true;
      }
   }
   return false;
}

// -----------------------

function nv_iChars_Remove(str)
{
   return str.replace(nv_specialchars, "");
}

// -----------------------

function formatStringAsUriComponent( s )
{

   // replace html with whitespace
   s = s.replace( /<\/?[^>]*>/gm, " " );

   // remove entities
   s = s.replace( /&[\w]+;/g, "" );

   // remove 'punctuation'
   s = s.replace ( /[\.\,\"\'\?\!\;\:\#\$\%\&\(\)\*\+\-\/\<\>\=\@\[\]\\^\_\{\}\|\~]/g, "");

   // replace multiple whitespace with single whitespace
   s = s.replace( /\s{2,}/g, " " );

   // trim whitespace at start and end of title
   s = s.replace( /^\s+|\s+$/g, "" );

   return s;
}

// -----------------------

function nv_setCookie(name, value, expiredays)
{
   if (expiredays)
   {
      var exdate = new Date();
      exdate.setDate(exdate.getDate() + expiredays);
      var expires = exdate.toGMTString();
   }
   var is_url  = /^([0-9a-z][0-9a-z-]+\.)+[a-z]{2,6}$/;
   var domainName = document.domain;
   domainName = domainName.replace(/www\./g,'');
   domainName = is_url.test( domainName ) ? '.' + domainName : '';
   document.cookie = name + "=" + escape(value) + ((expiredays) ? "; expires=" + expires : "") + ((domainName) ? "; domain=" + domainName : "") + "; path=" + nv_siteroot;
}

// -----------------------

function nv_getCookie(name)
{
   var cookie = " " + document.cookie;
   var search = " " + name + "=";
   var setStr = null;
   var offset = 0;
   var end = 0;
   if (cookie.length > 0)
   {
      offset = cookie.indexOf(search);
      if (offset != - 1)
      {
         offset += search.length;
         end = cookie.indexOf(";", offset)
         if (end == - 1)
         {
            end = cookie.length;
         }
         setStr = unescape(cookie.substring(offset, end));
      }
   }
   return setStr;
}

// -----------------------

function nv_check_timezone()
{
    var is_url  = /^([0-9a-z][0-9a-z-]+\.)+[a-z]{2,6}$/;
    var domainName = document.domain;
    domainName = domainName.replace(/www\./g,'');
    domainName = is_url.test( domainName ) ? '.' + domainName : '';

    var cookie_timezone = nv_getCookie( nv_cookie_prefix + '_cltz' );
    var giohientai = new Date();
    var giomuahe = new Date(Date.UTC(2005, 6, 30, 0, 0, 0, 0));
    var giomuadong = new Date(Date.UTC(2005, 12, 30, 0, 0, 0, 0));
    var new_value = -giomuahe.getTimezoneOffset() + '.' + -giomuadong.getTimezoneOffset() + '.' + -giohientai.getTimezoneOffset();
    new_value += '|' + nv_siteroot;
    new_value += '|' + domainName;
    
   if( rawurldecode(cookie_timezone) != new_value)
   {
      nv_setCookie( nv_cookie_prefix + '_cltz', rawurlencode(new_value), 365 );
      //Khong biet bac nao viet them vao cho nay ma vo ly qua. Xin loi xoa nhe!
      //cookie_timezone = nv_getCookie( nv_cookie_prefix + '_cltz' );
      /*if( rawurldecode(cookie_timezone) == new_value){
    	  window.location.href = strHref;
      }*/
   }
}

// -----------------------

function is_array( mixed_var )
{
   return ( mixed_var instanceof Array );
}

// -----------------------

// strip_tags('<p>Kevin</p> <b>van</b> <i>Zonneveld</i>', '<i><b>');
function strip_tags (str, allowed_tags)
{
   var key = '', allowed = false;
   var matches = [];
   var allowed_array = [];
   var allowed_tag = '';
   var i = 0;
   var k = '';
   var html = '';

   var replacer = function (search, replace, str)
   {
      return str.split(search).join(replace);
   }
   ;

   // Build allowes tags associative array
   if (allowed_tags)
   {
      allowed_array = allowed_tags.match(/([a-zA-Z0-9]+)/gi);
   }

   str += '';

   // Match tags
   matches = str.match(/(<\/?[\S][^>]*>)/gi);

   // Go through all HTML tags
   for (key in matches)
   {
      if (isNaN(key))
      {
         // IE7 Hack
         continue;
      }

      // Save HTML tag
      html = matches[key].toString();

      // Is tag not in allowed list ? Remove from str !
      allowed = false;

      // Go through all allowed tags
      for (k in allowed_array)
      {
         // Init
         allowed_tag = allowed_array[k];
         i = - 1;

         if (i != 0)
         {
            i = html.toLowerCase().indexOf('<' + allowed_tag + '>');
         }
         if (i != 0)
         {
            i = html.toLowerCase().indexOf('<' + allowed_tag + ' ');
         }
         if (i != 0)
         {
            i = html.toLowerCase().indexOf('</' + allowed_tag)   ;
         }

         // Determine
         if (i == 0)
         {
            allowed = true;
            break;
         }
      }

      if ( ! allowed)
      {
         str = replacer(html, "", str);
         // Custom replace. No regexing
      }
   }

   return str;
}

// -----------------------

// trim(' Kevin van Zonneveld ');
function trim (str, charlist)
{
   var whitespace, l = 0, i = 0;
   str += '';

   if ( ! charlist)
   {
      whitespace = " \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";
   }
   else
   {
      charlist += '';
      whitespace = charlist.replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '$1');
   }

   l = str.length;
   for (i = 0; i < l; i ++ )
   {
      if (whitespace.indexOf(str.charAt(i)) === - 1)
      {
         str = str.substring(i);
         break;
      }
   }

   l = str.length;
   for (i = l - 1; i >= 0; i -- )
   {
      if (whitespace.indexOf(str.charAt(i)) === - 1)
      {
         str = str.substring(0, i + 1);
         break;
      }
   }

   return whitespace.indexOf(str.charAt(0)) === - 1 ? str : '';
}

// -----------------------

// rawurlencode('Kevin van Zonneveld!'); = > 'Kevin%20van%20Zonneveld%21'
function rawurlencode (str)
{

   str = (str + '').toString();
    return encodeURIComponent( str ).replace( /!/g, '%21' ).replace( /'/g, '%27').replace(/\(/g, '%5B').replace(/\)/g, '%5D').replace(/\*/g, '%2A');
}

// -----------------------

// rawurldecode('Kevin+van+Zonneveld%21'); = > 'Kevin+van+Zonneveld!'
function rawurldecode (str)
{
   return decodeURIComponent(str);
}

// -----------------------

function is_numeric( mixed_var )
{
   return ! isNaN( mixed_var );
}

// -----------------------

function intval (mixed_var, base)
{
   var type = typeof( mixed_var );

   if (type === 'boolean')
   {
      return (mixed_var) ? 1 : 0;
   }
   else if (type === 'string')
   {
      tmp = parseInt(mixed_var, base || 10);
      return (isNaN(tmp) || ! isFinite(tmp)) ? 0 : tmp;
   }
   else if (type === 'number' && isFinite(mixed_var) )
   {
      return Math.floor(mixed_var);
   }
   else
   {
      return 0;
   }
}

// -----------------------

function AJAX()
{
   this.http_request = false;
   this.mimetype = 'text/html';
   this.callback = false;
   this.containerid = false;
   this.rmethod = 'POST';
   this.response = 'text';
   this.request = function( request_method, request_url, request_query, containerid, callback )
   {
      if ( typeof( XMLHttpRequest ) != 'undefined' )
      {
         this.http_request = new XMLHttpRequest();
      }
      else if( window.ActiveXObject )
      {
         try
         {
            this.http_request = new ActiveXObject( "Msxml2.XMLHTTP" );

         }
         catch ( e )
         {
            try
            {
               this.http_request = new ActiveXObject( "Microsoft.XMLHTTP" );

            }
            catch ( e )
            {
            }
         }
      }
      if( ! this.http_request || ! request_url ) return;
      if( request_method.toLowerCase() == 'get' )
      {
         this.rmethod = 'GET';
         if( request_query )
         {
            request_url += ( request_url.indexOf( "?" ) + 1 ) ? "&" : "?";
            request_url += request_query;
         }
      }
      request_url += ( request_url.indexOf( "?" ) + 1 ) ? "&" : "?";
      request_url += 'nocache=' + new Date().getTime();

      if ( typeof( containerid ) != 'undefined' ) this.containerid = containerid;
      if ( typeof( callback ) != 'undefined' ) this.callback = callback;

      if ( this.http_request.overrideMimeType ) this.http_request.overrideMimeType( this.mimetype );
      var ths = this;
      this.http_request.onreadystatechange = function()
      {
         if( ! ths ) return;
         switch( ths.http_request.readyState )
         {
            case 1 :
            case 2 :
            case 3 :
               // if( ths.containerid && ! ths.callback )
				// document.getElementById( ths.containerid ).innerHTML = "<div
				// style=\"text - align : center; \"><img alt=\"Loading...\"
				// src=\"" + nv_siteroot + "images / load.gif\" width=\"16\"
				// height=\"16\" /></div>";
               break;

            case 4 :
               if( ths.http_request.status == 200 )
               {
                  if( ths.response == 'xml' && ths.http_request.responseXML )
                  {
                     ths.result = ths.http_request.responseXML;
                  }
                  else if( ths.response == 'text' && ths.http_request.responseText )
                  {
                     ths.result = ths.http_request.responseText;
                  }
                  
                  if(typeof( ths.result ) == 'undefined')
                  {
                    ths.result = "";
                  }
                  
                  if( ! ths.callback )
                  {
                     if( ths.containerid )
                     {
                        document.getElementById( ths.containerid ).innerHTML = ths.result;
                     }
                  }
                  else
                  {
                     if(ths.result)
                     {
                        ths.result = ths.result.replace( /[\n\r]/g, '' );
                     }
                     eval( ths.callback + '(\'' + ths.result + '\');' );
                  }
               }
               else
               {
                  if( ths.containerid && ! ths.callback ) document.getElementById( ths.containerid ).innerHTML = 'There was a problem with the request.';
               }
               break;
         }
      }

      this.http_request.open( this.rmethod, request_url, true );
      if( this.rmethod == 'GET' )
      {
         this.http_request.send( null );
      }
      else
      {
         this.http_request.setRequestHeader( "Content-type", "application/x-www-form-urlencoded" );
         this.http_request.setRequestHeader( "Content-length", request_query.length );
         this.http_request.setRequestHeader( "Connection", "close" );
         this.http_request.send( request_query );
      }
   }
}

// -----------------------

function nv_get_element_value( formElement )
{
   if( formElement.length != null ) var type = formElement[0].type;
   if( ( typeof( type ) == 'undefined' ) || ( type == 0 ) ) var type = formElement.type;

   var val = '';
   switch( type )
   {
      case 'undefined' :
      break;

      case 'radio' :
      if( formElement.checked )
      {
         val = formElement.value;
      }
      break;

      case 'select-multiple' :
      var myArray = new Array();
      for( var x = 0; x < formElement.length; x ++ )
      {
         if( formElement[x].selected == true )
         {
            myArray[myArray.length] = formElement[x].value;
         }
      }
      val = myArray;
      break;

      case 'checkbox' :
      val = formElement.checked;
      break;

      default :
      val = formElement.value;
   }
   return val;
}

// -----------------------

function nv_ajax( request_method, request_url, request_query, containerid, callback )
{
   object = new AJAX();
   object.request( request_method, request_url, request_query, containerid, callback );
}

// -----------------------

function nv_form_send( form, containerid, callback )
{
   var query = "";
   var z = 0;
   for( var i = 0; i < form.elements.length; i ++ )
   {
      var pkey = form.elements[i].name;
      var pvalue = nv_get_element_value( form.elements[i] );
      if( pkey && pvalue )
      {
         z ++ ;
         if( z > 1 )
         {
            query += "&";
         }
         if( form.method.toLowerCase() == 'get' )
         {
            pkey = encodeURIComponent( pkey );
            pvalue = encodeURIComponent( pvalue );
         }
         query += pkey + "=" + pvalue;
      }
   }
   nv_ajax( form.method, form.action, query, containerid, callback );
}

// -----------------------

function nv_is_dst()
{
   var now = new Date();
   var dst_start = new Date();
   var dst_end = new Date();
   // Set dst start to 2AM 2nd Sunday of March
   dst_start.setMonth( 2 );
   // March
   dst_start.setDate( 1 );
   // 1st
   dst_start.setHours( 2 );
   dst_start.setMinutes( 0 );
   dst_start.setSeconds( 0 );
   // 2AM
   // Need to be on first Sunday
   if( dst_start.getDay() ) dst_start.setDate( dst_start.getDate() + ( 7 - dst_start.getDay() ) );
   // Set to second Sunday
   dst_start.setDate( dst_start.getDate() + 7 );
   // Set dst end to 2AM 1st Sunday of November
   dst_end.setMonth( 10 );
   dst_end.setDate( 1 );
   dst_end.setHours( 2 );
   dst_end.setMinutes( 0 );
   dst_end.setSeconds( 0 );
   // 2AM
   // Need to be on first Sunday
   if( dst_end.getDay() ) dst_end.setDate( dst_end.getDate() + ( 7 - dst_end.getDay() ) );
   return ( now > dst_start && now < dst_end )
}

// -----------------------

function nv_DigitalClock( div_id )
{
   if( document.getElementById( div_id ) )
   {
      if( nv_my_dst )
      {
         var test_dst = nv_is_dst();
         if( test_dst ) nv_my_ofs += 1;
      }

      var newDate = new Date();
      var ofs = newDate.getTimezoneOffset() / 60;
      newDate.setHours( newDate.getHours() + ofs + nv_my_ofs );

      var intMinutes = newDate.getMinutes();
      var intSeconds = newDate.getSeconds();
      if( intMinutes != nv_old_Minute )
      {
         nv_old_Minute = intMinutes;
         var intDay = newDate.getDay();
         var intMonth = newDate.getMonth();
         var intWeekday = newDate.getDate();
         var intYear = newDate.getYear();
         var intHours = newDate.getHours();

         if ( intYear < 200 ) intYear = intYear + 1900;
         var strDayName = new String( nv_aryDayName[intDay] );
         var strDayNameShort = new String( nv_aryDayNS[intDay] );
         var strMonthName = new String( nv_aryMonth[intMonth] );
         var strMonthNameShort = new String( nv_aryMS[intMonth] );
         var strMonthNumber = intMonth + 1;
         var strYear = new String( intYear );
         var strYearShort = strYear.substring( 2, 4 );

         if ( intHours <= 9 ) intHours = '0' + intHours;
         if ( intMinutes  <= 9 ) intMinutes  = '0' + intMinutes;
         // if ( intSeconds <= 9 ) intSeconds = '0' + intSeconds;
         if ( intWeekday <= 9 ) intWeekday = '0' + intWeekday;
         if ( strMonthNumber <= 9 ) strMonthNumber = '0' + strMonthNumber;

         var strClock = '';
         // strClock = intHours + ':' + intMinutes + ':' + intSeconds + ' ' +
			// GMT
         // + ' &nbsp; ' + strDayName + ', ' + intWeekday + '/' +
			// strMonthNumber
         // + '/' + intYear;
         strClock = intHours + ':' + intMinutes + ' ' + nv_my_abbr + ' &nbsp; ' + strDayName + ', ' + intWeekday + '/' + strMonthNumber + '/' + intYear;
         var spnClock = document.getElementById( div_id );
         spnClock.innerHTML = strClock;
      }
      setTimeout( 'nv_DigitalClock("'+div_id+'")', ( 60 - intSeconds ) * 1000 );
   }
}

// -----------------------

function nv_search_submit(search_query, topmenu_search_checkss, search_button, minlength, maxlength)
{
   var query = document.getElementById(search_query);
   var format_query = formatStringAsUriComponent(query.value);
   var allowed = ( format_query != '' && format_query.length >= minlength && format_query.length <= maxlength) ? true : false;
   if( ! allowed)
   {
      query.value = format_query;
      messalert = nv_rangelength.replace('{0}', minlength);
      messalert = messalert.replace('{1}', maxlength);
      alert(messalert);
   }
   else
   {
      var sbutton = document.getElementById(search_button);
      sbutton.disabled = true;
      var search_checkss = document.getElementById(topmenu_search_checkss).value;
      window.location.href = nv_siteroot + 'index.php?' + nv_lang_variable+'='+nv_sitelang+'&'+nv_name_variable + '=search&q=' + rawurlencode(format_query) + '&search_checkss=' + search_checkss;
   }
   return false;
}

// -----------------------

function nv_show_hidden(div_id, st)
{
   var divid = document.getElementById(div_id);
   if(st == 2)
   {
      if(divid.style.visibility == 'hidden' || divid.style.display == 'none')
      {
         divid.style.visibility = 'visible';
         divid.style.display = 'block';
      }
      else
      {
         divid.style.visibility = 'hidden';
         divid.style.display = 'none';
      }
   }
   else if(st == 1)
   {
      divid.style.visibility = 'visible';
      divid.style.display = 'block';
   }
   else
   {
      divid.style.visibility = 'hidden';
      divid.style.display = 'none';
   }
   return;
}

// -----------------------

function nv_checkAll(oForm, cbName, caName, check_value)
{
    if(oForm[cbName].length)
    {
        for (var i = 0; i < oForm[cbName].length; i ++ )
        {
            oForm[cbName][i].checked = check_value;
        }
    }
    else
    {
        oForm[cbName].checked = check_value;
    }
    
    if(oForm[caName].length)
    {
        for (var j = 0; j < oForm[caName].length; j ++ )
        {
            oForm[caName][j].checked = check_value;
        }
    }
    else
    {
        oForm[caName].checked = check_value;
    }
}

// -----------------------

function nv_UncheckAll(oForm, cbName, caName, check_value)
{
   var ts = 0;
   
    if(oForm[cbName].length)
    {
        for (var i = 0; i < oForm[cbName].length; i ++ )
        {   
            if(oForm[cbName][i].checked != check_value)
            {
                ts = 1;
                break;
            }
        }
    }
   
    var chck = false;
    if(ts == 0)
    {
        chck = check_value;
    }
   
    if(oForm[caName].length)
    {
        for (var j = 0; j < oForm[caName].length; j ++ )
        {
            oForm[caName][j].checked = chck;
        }
    }
    else
    {
        oForm[caName].checked = chck;
    }
}

// -----------------------

function nv_set_disable_false(sid)
{
    if(document.getElementById( sid ))
    {
        var sd = document.getElementById( sid );
        sd.disabled = false;
    }

}

// -----------------------

function nv_settimeout_disable(sid, tm)
{
   var sd = document.getElementById( sid );
   sd.disabled = true;
   nv_timer = setTimeout('nv_set_disable_false("'+sid+'")', tm);
   return nv_timer;
}

// -----------------------

function nv_randomPassword( plength )
{
   var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
   var pass = "";
   for( var z = 0; z < plength; z ++ )
   {
      pass += chars.charAt( Math.floor( Math.random() * 62 ) );
   }
   return pass;
}

// -----------------------

function nv_urldecode_ajax(my_url, containerid)
{
   my_url = rawurldecode(my_url);
   nv_ajax( 'get', my_url, '', containerid );
   return;
}

function nv_change_captcha(imgid,captchaid)
{
   var vimg = document.getElementById( imgid );
   nocache = nv_randomPassword( 10 );
   vimg.src = nv_siteroot + 'index.php?scaptcha=captcha&nocache=' + nocache;
   document.getElementById( captchaid ).value = '';
   return false;
}

function NewWindow(mypage,myname,w,h,scroll){
	var win = null;
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
	win = window.open(mypage,myname,settings)
}

nv_check_timezone();