function nv_randomNum( a )
{
    for( var b = "", d = 0; d < a; d++ )
    {
        b += "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890".charAt( Math.floor( Math.random() * 62 ) )
    }
    return b
}

//  ---------------------------------------

function resize_byWidth( a, b, d )
{
    return Math.round( d / a * b )
}

//  ---------------------------------------

function resize_byHeight( a, b, d )
{
    return Math.round( d / b * a )
}

//  ---------------------------------------

function calSize( a, b, d, e )
{
    if( a > d )
    {
        b = resize_byWidth( a, b, d );
        a = d
    }
    if( b > e )
    {
        a = resize_byHeight( a, b, e );
        b = e
    }
    return[a, b]
}

//  ---------------------------------------

function calSizeMax( a, b, d, e )
{
    var g = d;
    d = resize_byWidth( a, b, d );
    if( !( d <= e ) )
    {
        d = e;
        g = resize_byHeight( a, b, e )
    }
    return[g, d]
}

//  ---------------------------------------

function calSizeMin( a, b, d, e )
{
    var g = d;
    d = resize_byWidth( a, b, d );
    if( !( d >= e ) )
    {
        d = e;
        g = resize_byHeight( a, b, e )
    }
    return[g, d]
}

//  ---------------------------------------

function is_numeric( a )
{
    return( typeof a === "number" || typeof a === "string" ) && a !== "" && !isNaN( a )
}

//  ---------------------------------------

function checkNewSize()
{
    var a = $( "input[name=newWidth]" ).val(), b = $( "input[name=newHeight]" ).val(), d = [], e = $( "input[name=origWidth]" ).val(), g = $( "input[name=origHeight]" ).val(), h = calSizeMax( e, g, nv_max_width, nv_max_height );
    e = calSizeMin( e, g, nv_min_width, nv_min_height );
    if( a == "" || !is_numeric( a ) )
    {
        d = [LANG.errorEmptyX, "newWidth"]
    }
    else
    {
        if( a > h[0] )
        {
            d = [LANG.errorMaxX, "newWidth"]
        }
        else
        {
            if( a < e[0] )
            {
                d = [LANG.errorMinX, "newWidth"]
            }
            else
            {
                if( b == "" || !is_numeric( b ) )
                {
                    d = [LANG.errorEmptyY, "newHeight"]
                }
                else
                {
                    if( b > h[1] )
                    {
                        d = [LANG.errorMaxY, "newHeight"]
                    }
                    else
                    {
                        if( b < e[1] )
                        {
                            d = [LANG.errorMinY, "newHeight"]
                        }
                    }
                }
            }
        }
    }
    $( "div[title=createInfo]" ).find( "div" ).remove();
    if( typeof d[0] != "undefined" )
    {
        $( "div[title=createInfo]" ).prepend( '<div class="red">' + d[0] + "</div>" );
        $( "input[name='" + d[1] + "']" ).select();
        return false
    }
    a = calSize( a, b, 360, 230 );
    $( "img[name=myFile2]" ).width( a[0] ).height( a[1] );
    return true
}

//  ---------------------------------------

function pathList( a, b )
{
    var d = [];
    $( "#foldertree" ).find( "span" ).each( function()
    {
        if( $( this ).attr( "title" ) == b || $( this ).attr( "title" ) != "" && $( this ).is( "." + a ) )
        {
            d[d.length] = $( this ).attr( "title" )
        }
    }
    );
    return d
}

//  ---------------------------------------

function insertvaluetofield()
{
    var a = $( "input[name=CKEditorFuncNum]" ).val(), b = $( "input[name=area]" ).val(), d = nv_base_siteurl + $( "span#foldervalue" ).attr( "title" ) + "/" + $( "input[name=selFile]" ).val();
    if( a > 0 )
    {
        window.opener.CKEDITOR.tools.callFunction( a, d, "" );
        window.close()
    }
    if( b != "" )
    {
        $( "#" + b, opener.document ).val( d );
        window.close()
    }
}

function nv_selFile(d)
{
    var a = $( "input[name=CKEditorFuncNum]" ).val(), b = $( "input[name=area]" ).val();
    if( a > 0 )
    {
        window.opener.CKEDITOR.tools.callFunction( a, d, "" );
        window.close()
    }
    if( b != "" )
    {
        $( "#" + b, opener.document ).val( d );
        window.close()
    }
}

//  ---------------------------------------

function download()
{
    var a = $( "span#foldervalue" ).attr( "title" ), b = $( "input[name=selFile]" ).val();
    $( "iframe#Fdownload" ).attr( "src", nv_module_url + "dlimg&path=" + a + "&img=" + b )
}

//  ---------------------------------------

function preview()
{
    $( "div.dynamic" ).text( "" );
    $( "input.dynamic" ).val( "" );
    var a = $( "input[name=selFile]" ).val(), b = $( "span#foldervalue" ).attr( "title" ), d = $( "img[title='" + a + "']" ).attr( "name" ), e = LANG.upload_size + ": ";
    d = d.split( "|" );
    if( d[3] == "image" || d[2] == "swf" )
    {
        var g = calSize( d[0], d[1], 360, 230 );
        e += d[0] + " x " + d[1] + " pixels (" + d[4] + ")<br />";
        d[3] == "image" ? $( "div#fileView" ).html( '<img style="border:2px solid #F0F0F0;" width="' + g[0] + '" height="' + g[1] + '" src="' + nv_base_siteurl + b + "/" + a + '" />' ) : $( "#fileView" ).flash(
        {
            src:nv_base_siteurl + b + "/" + a, width:g[0], height:g[1]
        }
        ,
        {
            version:8
        }
        )
    }
    else
    {
        e += d[4] + "<br />";
        b = $( "div[title='" + a + "'] div" ).html();
        $( "div#fileView" ).html( b )
    }
    e += LANG.pubdate + ": " + d[6];
    $( "#fileInfoDetail" ).html( e );
    $( "#fileInfoName" ).html( a );
    $( "div#imgpreview" ).dialog(
    {
        autoOpen:false, width:388, modal:true, position:"center"
    }
    ).dialog( "open" ).dblclick( function()
    {
        $( "div#imgpreview" ).dialog( "close" )
    }
    )
}

//  ---------------------------------------

function create()
{
    $( "div.dynamic" ).text( "" );
    $( "input.dynamic" ).val( "" );
    var a = $( "input[name=selFile]" ).val(), b = $( "span#foldervalue" ).attr( "title" ), d = $( "img[title='" + a + "']" ).attr( "name" );
    d = d.split( "|" );
    if( d[3] == "image" )
    {
        $( "input[name=origWidth]" ).val( d[0] );
        $( "input[name=origHeight]" ).val( d[1] );
        var e = calSizeMax( d[0], d[1], nv_max_width, nv_max_height ), g = calSizeMin( d[0], d[1], nv_min_width, nv_min_height );
        $( "div[title=createInfo]" ).html( "Max: " + e[0] + " x " + e[1] + ", Min: " + g[0] + " x " + g[1] + " (pixels)" );
        e = calSize( d[0], d[1], 360, 230 );
        $( "img[name=myFile2]" ).width( e[0] ).height( e[1] ).attr( "src", nv_base_siteurl + b + "/" + a );
        $( "#fileInfoDetail2" ).html( LANG.origSize + ": " + d[0] + " x " + d[1] + " pixels" );
        $( "#fileInfoName2" ).html( a );
        $( "div#imgcreate" ).dialog(
        {
            autoOpen:false, width:650, modal:true, position:"center"
        }
        ).dialog( "open" )
    }
}

//  ---------------------------------------

function move()
{
    $( "div.dynamic" ).text( "" );
    $( "input.dynamic" ).attr( "checked", false );
    var a = $( "span#foldervalue" ).attr( "title" ), b = pathList( "create_file", a ), d, e, g = $( "input[name=selFile]" ).val();
    for( e in b )
    {
        d = a == b[e] ? ' selected="selected"' : "";
        $( "select[name=newPath]" ).append( '<option value="' + b[e] + '"' + d + ">" + b[e] + "</option>" )
    }
    $( "div[title=pathFileName]" ).text( a + "/" + g );
    $( "div#filemove" ).dialog(
    {
        autoOpen:false, width:300, modal:true, position:"center"
    }
    ).dialog( "open" )
}

//  ---------------------------------------

function filerename()
{
    $( "div.dynamic, span.dynamic" ).text( "" );
    $( "input.dynamic" ).val( "" );
    var a = $( "input[name=selFile]" ).val();
    $( "div#filerenameOrigName" ).text( a );
    a = a.replace( /^(.+)\.([a-zA-Z0-9]+)$/, "$2" );
    $( "span[title=Ext]" ).text( "." + a );
    $( "div#filerename" ).dialog(
    {
        autoOpen:false, width:300, modal:true, position:"center"
    }
    ).dialog( "open" )
}

//  ---------------------------------------

function filedelete()
{
    var a = $( "input[name=selFile]" ).val(), b = $( "span#foldervalue" ).attr( "title" ), d = $( "select[name=imgtype]" ).val(), e = $( "select[name=author]" ).val() == 1 ? "&author" : "";
    confirm( LANG.upload_delimg_confirm + " " + a + " ?" ) && $.ajax(
    {
        type:"POST", url:nv_module_url + "delimg", data:"path=" + b + "&file=" + a, success:function()
        {
            $( "#imglist" ).load( nv_module_url + "imglist&path=" + b + "&type=" + d + e + "&num=" + +nv_randomNum( 10 ) )
        }
    }
    )
}

//  ---------------------------------------

function fileMouseup( a )
{
    $( ".imgsel" ).removeClass( "imgsel" );
    $( a ).addClass( "imgsel" );
    a = $( a ).attr( "title" );
    $( "input[name=selFile]" ).val( a );
    a = a.slice( -3 );
    var b = $( "input[name=CKEditorFuncNum]" ).val(), d = $( "input[name=area]" ).val(), e = "<ul>";
    if( b > 0 || d != "" )
    {
        e += '<li id="select"><img style="margin-right:5px" src="' + ICON.select + '"/>' + LANG.select + "</li>"
    }
    e += '<li id="download"><img style="margin-right:5px" src="' + ICON.download + '"/>' + LANG.download + "</li>";
    e += '<li id="filepreview"><img style="margin-right:5px" src="' + ICON.preview + '"/>' + LANG.preview + "</li>";
    if( $.inArray( a, array_images ) !== -1 && $( "span#create_file" ).attr( "title" ) == "1" )
    {
        e += '<li id="create"><img style="margin-right:5px" src="' + ICON.create + '"/>' + LANG.upload_createimage + "</li>"
    }
    if( $( "span#move_file" ).attr( "title" ) == "1" )
    {
        e += '<li id="move"><img style="margin-right:5px" src="' + ICON.move + '"/>' + LANG.move + "</li>"
    }
    if( $( "span#rename_file" ).attr( "title" ) == "1" )
    {
        e += '<li id="rename"><img style="margin-right:5px" src="' + ICON.rename + '"/>' + LANG.rename + "</li>"
    }
    if( $( "span#delete_file" ).attr( "title" ) == "1" )
    {
        e += '<li id="filedelete"><img style="margin-right:5px" src="' + ICON.filedelete + '"/>' + LANG.upload_delfile + "</li>"
    }
    e += "</ul>";
    $( "div#contextMenu" ).html( e )
}

//  ---------------------------------------

function is_allowed_upload()
{
    $( "input[name=fileupload]" ).parent().css( "display", "block" );
    $( "span#upload_file" ).attr( "title" ) == "1" ? $( "input[name=fileupload]" ).parent().parent().css( "display", "block" ).next().css( "display", "none" ) : $( "input[name=fileupload]" ).parent().parent().css( "display", "none" ).next().css( "display", "block" )
}

//  ---------------------------------------

function folderClick( a )
{
    var b = $( a ).attr( "title" );
    if( b != $( "span#foldervalue" ).attr( "title" ) )
    {
        $( "span#foldervalue" ).attr( "title", b );
        $( "span#view_dir" ).attr( "title", $( a ).is( ".view_dir" ) ? "1" : "0" );
        $( "span#create_dir" ).attr( "title", $( a ).is( ".create_dir" ) ? "1" : "0" );
        $( "span#rename_dir" ).attr( "title", $( a ).is( ".rename_dir" ) ? "1" : "0" );
        $( "span#delete_dir" ).attr( "title", $( a ).is( ".delete_dir" ) ? "1" : "0" );
        $( "span#upload_file" ).attr( "title", $( a ).is( ".upload_file" ) ? "1" : "0" );
        $( "span#create_file" ).attr( "title", $( a ).is( ".create_file" ) ? "1" : "0" );
        $( "span#rename_file" ).attr( "title", $( a ).is( ".rename_file" ) ? "1" : "0" );
        $( "span#delete_file" ).attr( "title", $( a ).is( ".delete_file" ) ? "1" : "0" );
        $( "span#move_file" ).attr( "title", $( a ).is( ".move_file" ) ? "1" : "0" );
        $( "span.folder" ).css( "color", "" );
        $( a ).css( "color", "red" );
        if( $( a ).is( ".view_dir" ) )
        {
            a = $( "select[name=imgtype]" ).val();
            var d = $( "input[name=selFile]" ).val(), e = $( "select[name=author]" ).val() == 1 ? "&author" : "";
            $( "div#imglist" ).load( nv_module_url + "imglist&path=" + b + "&imgfile=" + d + "&type=" + a + e + "&random=" + nv_randomNum( 10 ) )
        }
        else
        {
            $( "div#imglist" ).text( "" )
        }
        is_allowed_upload()
    }
}

//  ---------------------------------------

function menuMouseup( a )
{
    $( a ).attr( "title" );
    $( "span" ).attr( "name", "" );
    $( a ).attr( "name", "current" );
    var b = "";
    if( $( a ).is( ".create_dir" ) )
    {
        b += '<li id="createfolder"><img style="margin-right:5px" src="' + ICON.create + '"/>' + LANG.createfolder + "</li>"
    }
    if( $( a ).is( ".rename_dir" ) )
    {
        b += '<li id="renamefolder"><img style="margin-right:5px" src="' + ICON.rename + '"/>' + LANG.renamefolder + "</li>"
    }
    if( $( a ).is( ".delete_dir" ) )
    {
        b += '<li id="deletefolder"><img style="margin-right:5px" src="' + ICON.filedelete + '"/>' + LANG.deletefolder + "</li>"
    }
    if( b != "" )
    {
        b = "<ul>" + b + "</ul>"
    }
    $( "div#contextMenu" ).html( b )
}

//  ---------------------------------------

function renamefolder()
{
    var a = $( "span[name=current]" ).attr( "title" ).split( "/" );
    a = a[a.length - 1];
    $( "input[name=foldername]" ).val( a );
    $( "div#renamefolder" ).dialog( "open" )
}

//  ---------------------------------------

function createfolder()
{
    $( "input[name=createfoldername]" ).val( "" );
    $( "div#createfolder" ).dialog( "open" )
}

//  ---------------------------------------

function deletefolder()
{
    if( confirm( LANG.delete_folder ) )
    {
        var a = $( "span[name=current]" ).attr( "title" );
        $.ajax(
        {
            type:"POST", url:nv_module_url + "delfolder&random=" + nv_randomNum( 10 ), data:"path=" + a, success:function( b )
            {
                b = b.split( "_" );
                if( b[0] == "ERROR" )
                {
                    alert( b[1] )
                }
                else
                {
                    b = a.split( "/" );
                    a = "";
                    for( i = 0; i < b.length - 1; i++ )
                    {
                        if( a != "" )
                        {
                            a += "/"
                        }
                        a += b[i]
                    }
                    b = $( "select[name=imgtype]" ).val();
                    var d = $( "select[name=author]" ).val() == 1 ? "&author" : "", e = $( "span#path" ).attr( "title" ), g = $( "input[name=selFile]" ).val();
                    $( "#imgfolder" ).load( nv_module_url + "folderlist&path=" + e + "&currentpath=" + a + "&random=" + nv_randomNum( 10 ) );
                    $( "div#imglist" ).load( nv_module_url + "imglist&path=" + a + "&imgfile=" + g + "&type=" + b + d + "&random=" + nv_randomNum( 10 ) )
                }
            }
        }
        )
    }
}

//  ---------------------------------------

$( "select[name=imgtype]" ).change( function()
{
    var a = $( "span#foldervalue" ).attr( "title" ), b = $( this ).val(), d = $( "input[name=selFile]" ).val(), e = $( "select[name=author]" ).val() == 1 ? "&author" : "";
    $( "#imglist" ).load( nv_module_url + "imglist&path=" + a + "&type=" + b + "&imgfile=" + d + e + "&random=" + nv_randomNum( 10 ) )
}

//  ---------------------------------------

 );
$( "select[name=author]" ).change( function()
{
    var a = $( "span#foldervalue" ).attr( "title" ), b = $( "input[name=selFile]" ).val(), d = $( "select[name=imgtype]" ).val(), e = $( this ).val() == 1 ? "&author" : "";
    $( "#imglist" ).load( nv_module_url + "imglist&path=" + a + "&type=" + d + "&imgfile=" + b + e + "&random=" + nv_randomNum( 10 ) )
}

//  ---------------------------------------

 );
$( ".refresh a" ).click( function()
{
    var a = $( "span#foldervalue" ).attr( "title" ), b = $( "select[name=imgtype]" ).val(), d = $( "input[name=selFile]" ).val(), e = $( "select[name=author]" ).val() == 1 ? "&author" : "", g = $( "span#path" ).attr( "title" );
    $( "#imgfolder" ).load( nv_module_url + "folderlist&path=" + g + "&currentpath=" + a + "&dirListRefresh&random=" + nv_randomNum( 10 ) );
    $( "#imglist" ).load( nv_module_url + "imglist&path=" + a + "&type=" + b + "&imgfile=" + d + e + "&refresh&random=" + nv_randomNum( 10 ) );
    return false
}

//  ---------------------------------------

 );
$( "input[name=fileupload]" ).change( function()
{
    var a = $( this ).val();
    f = a.replace( /.*\\(.*)/, "$1" ).replace( /.*\/(.*)/, "$1" );
    $( this ).parent().prev().html( f );
    a = a + " " + $( "span#foldervalue" ).attr( "title" );
    $( "input[name=currentFileUpload]" ).val() != a && $( this ).parent().next().next().css( "display", "none" ).next().css( "display", "none" )
}

//  ---------------------------------------

 );
$( "input[name=imgurl]" ).change( function()
{
    $( this ).parent().next().next().css( "display", "none" ).next().css( "display", "none" )
}

//  ---------------------------------------

 );
$( "#confirm" ).click( function()
{
    var a = $( "input[name=fileupload]" ).val(), b = $( "span#foldervalue" ).attr( "title" ), d = $( "input[name=currentFileUpload]" ).val(), e = a + " " + b, g = $( "select[name=imgtype]" ).val(), h = $( "select[name=author]" ).val() == 1 ? "&author" : "";
    if( a != "" && d != e )
    {
        $( "input[name=fileupload]" ).parent().css( "display", "none" ).next().css( "display", "block" ).next().css( "display", "none" );
        $( "input[name=fileupload]" ).upload( nv_module_url + "upload&random=" + nv_randomNum( 10 ), "path=" + b, function( k )
        {
            $( "input[name=currentFileUpload]" ).val( e );
            var l = k.split( "_" );
            if( l[0] == "ERROR" )
            {
                $( "div#errorInfo" ).html( l[1] ).dialog( "open" );
                $( "input[name=fileupload]" ).parent().css( "display", "block" ).next().css( "display", "none" ).next().css( "display", "none" ).next().css( "display", "block" )
            }
            else
            {
                $( "input[name=fileupload]" ).parent().css( "display", "block" ).next().css( "display", "none" ).next().css( "display", "block" );
                $( "input[name=selFile]" ).val( k );
                var ckf = $( "input[name=CKEditorFuncNum]" ).val(), area = $( "input[name=area]" ).val();
                if( ckf > 0 || area != "" )
                {
                    $( "#cfile" ).html('<a href="javascript:void(0);" onclick="nv_selFile(\''+nv_base_siteurl+b+'/'+k+'\')">'+k+'</a>');
                }
                else{
                    $( "#cfile" ).html(k);
                }
                $( "#imglist" ).load( nv_module_url + "imglist&path=" + b + "&type=" + g + h + "&imgfile=" + k );
            }
        }
        , "html" )
    }
    else
    {
        a = $( "input[name=imgurl]" ).val();
        d = $( "input[name=currentFileUrl]" ).val();
        var j = a + " " + b;
        if( /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(a) &&
        d != j )
        {
            $( "input[name=imgurl]" ).parent().css( "display", "none" ).next().css( "display", "block" ).next().css( "display", "none" );
            $.ajax(
            {
                type:"POST", url:nv_module_url + "upload&random=" + nv_randomNum( 10 ), data:"path=" + b + "&fileurl=" + a, success:function( k )
                {
                    $( "input[name=currentFileUrl]" ).val( j );
                    var l = k.split( "_" );
                    if( l[0] == "ERROR" )
                    {
                        $( "div#errorInfo" ).html( l[1] ).dialog( "open" );
                        $( "input[name=imgurl]" ).parent().css( "display", "block" ).next().css( "display", "none" ).next().css( "display", "none" ).next().css( "display", "block" )
                    }
                    else
                    {
                        $( "input[name=imgurl]" ).parent().css( "display", "block" ).next().css( "display", "none" ).next().css( "display", "block" ).next().css( "display", "none" );
                        $( "input[name=selFile]" ).val( k );
                        $( "#imglist" ).load( nv_module_url + "imglist&path=" + b + "&type=" + g + "&imgfile=" + k + h + "&num=" + +nv_randomNum( 10 ) )
                    }
                }
            }
            )
        }
    }
}

//  ---------------------------------------

 );
$( "div#errorInfo" ).dialog(
{
    autoOpen:false, width:300, height:180, modal:true, position:"center", show:"slide"
}

//  ---------------------------------------

 );
$( "div#renamefolder" ).dialog(
{
    autoOpen:false, width:250, height:160, modal:true, position:"center", buttons:
    {
        Ok:function()
        {
            var a = $( "span[name=current]" ).attr( "title" ), b = $( "input[name=foldername]" ).val(), d = $( "span#foldervalue" ).attr( "title" ), e = a.split( "/" );
            e = e[e.length - 1];
            if( b == "" || b == e || !nv_namecheck.test( b ) )
            {
                alert( LANG.rename_nonamefolder );
                $( "input[name=foldername]" ).focus();
                return false
            }
            e = $( "span[name=current]" ).attr( "class" ).split( " " );
            e = e[e.length - 1];
            var g = true;
            $( "span." + e ).each( function()
            {
                var h = $( this ).attr( "title" ).split( "/" );
                h = h[h.length - 1];
                if( b == h )
                {
                    g = false
                }
            }
            );
            if( !g )
            {
                alert( LANG.folder_exists );
                $( "input[name=foldername]" ).focus();
                return false
            }
            $.ajax(
            {
                type:"POST", url:nv_module_url + "renamefolder&random=" + nv_randomNum( 10 ), data:"path=" + a + "&newname=" + b, success:function( h )
                {
                    var j = h.split( "_" );
                    if( j[0] == "ERROR" )
                    {
                        alert( j[1] )
                    }
                    else
                    {
                        j = h.split( "/" );
                        j = j[j.length - 1];
                        var k;
                        $( "span[name=current]" ).parent().find( "span" ).each( function()
                        {
                            k = $( this ).attr( "title" );
                            k = k.replace( a, h );
                            $( this ).attr( "title" ) == d && $( "span#foldervalue" ).attr( "title", k );
                            $( this ).attr( "title", k )
                        }
                        );
                        $( "span[name=current]" ).html( "&nbsp;" + j ).attr( "title", h )
                    }
                }
            }
            );
            $( this ).dialog( "close" )
        }
    }
}

//  ---------------------------------------

 );
$( "div#createfolder" ).dialog(
{
    autoOpen:false, width:250, height:160, modal:true, position:"center", buttons:
    {
        Ok:function()
        {
            var a = $( "input[name=createfoldername]" ).val(), b = $( "span[name=current]" ).attr( "title" );
            if( a == "" || !nv_namecheck.test( a ) )
            {
                alert( LANG.name_folder_error );
                $( "input[name=createfoldername]" ).focus();
                return false
            }
            $.ajax(
            {
                type:"POST", url:nv_module_url + "createfolder&random=" + nv_randomNum( 10 ), data:"path=" + b + "&newname=" + a, success:function( d )
                {
                    var e = d.split( "_" );
                    if( e[0] == "ERROR" )
                    {
                        alert( e[1] )
                    }
                    else
                    {
                        e = $( "select[name=imgtype]" ).val();
                        var g = $( "select[name=author]" ).val() == 1 ? "&author" : "", h = $( "span#path" ).attr( "title" );
                        $( "#imgfolder" ).load( nv_module_url + "folderlist&path=" + h + "&currentpath=" + d + "&random=" + nv_randomNum( 10 ) );
                        $( "div#imglist" ).load( nv_module_url + "imglist&path=" + d + "&type=" + e + g + "&random=" + nv_randomNum( 10 ) )
                    }
                }
            }
            );
            $( this ).dialog( "close" )
        }
    }
}

//  ---------------------------------------

 );
$( "input[name=newWidth], input[name=newHeight]" ).keyup( function()
{
    var a = $( this ).attr( "name" ), b = $( "input[name='" + a + "']" ).val(), d = $( "input[name=origWidth]" ).val(), e = $( "input[name=origHeight]" ).val(), g = calSizeMax( d, e, nv_max_width, nv_max_height );
    g = a == "newWidth" ? g[0] : g[1];
    if( !is_numeric( b ) || b > g || b < 0 )
    {
        $( "input[name=newWidth]" ).val( "" );
        $( "input[name=newHeight]" ).val( "" )
    }
    else
    {
        a == "newWidth" ? $( "input[name=newHeight]" ).val( resize_byWidth( d, e, b ) ) : $( "input[name=newWidth]" ).val( resize_byHeight( d, e, b ) )
    }
}

//  ---------------------------------------

 );
$( "input[name=prView]" ).click( function()
{
    checkNewSize()
}

//  ---------------------------------------

 );
$( "input[name=newSizeOK]" ).click( function()
{
    var a = $( "input[name=newWidth]" ).val(), b = $( "input[name=newHeight]" ).val(), d = $( "input[name=origWidth]" ).val(), e = $( "input[name=origHeight]" ).val();
    if( a == d && b == e )
    {
        $( "div#imgcreate" ).dialog( "close" )
    }
    else
    {
        if( checkNewSize() !== false )
        {
            $( this ).attr( "disabled", "disabled" );
            d = $( "input[name=selFile]" ).val();
            var g = $( "span#foldervalue" ).attr( "title" );
            $.ajax(
            {
                type:"POST", url:nv_module_url + "createimg", data:"path=" + g + "&img=" + d + "&width=" + a + "&height=" + b + "&num=" + nv_randomNum( 10 ), success:function( h )
                {
                    var j = h.split( "_" );
                    if( j[0] == "ERROR" )
                    {
                        alert( j[1] );
                        $( "input[name=newSizeOK]" ).removeAttr( "disabled" )
                    }
                    else
                    {
                        j = $( "select[name=imgtype]" ).val();
                        var k = $( "select[name=author]" ).val() == 1 ? "&author" : "";
                        $( "input[name=selFile]" ).val( h );
                        $( "input[name=newSizeOK]" ).removeAttr( "disabled" );
                        $( "div#imgcreate" ).dialog( "close" );
                        $( "#imglist" ).load( nv_module_url + "imglist&path=" + g + "&type=" + j + "&imgfile=" + h + k + "&num=" + +nv_randomNum( 10 ) )
                    }
                }
            }
            )
        }
    }
}

//  ---------------------------------------

 );
$( "input[name=newPathOK]" ).click( function()
{
    var a = $( "span#foldervalue" ).attr( "title" ), b = $( "select[name=newPath]" ).val(), d = $( "input[name=selFile]" ).val(), e = $( "input[name=mirrorFile]:checked" ).length;
    if( a == b )
    {
        $( "div#filemove" ).dialog( "close" )
    }
    else
    {
        $( this ).attr( "disabled", "disabled" );
        $.ajax(
        {
            type:"POST", url:nv_module_url + "moveimg&num=" + nv_randomNum( 10 ), data:"path=" + a + "&newpath=" + b + "&file=" + d + "&mirror=" + e, success:function( g )
            {
                var h = g.split( "_" );
                if( h[0] == "ERROR" )
                {
                    alert( h[1] );
                    $( "input[name=newPathOK]" ).removeAttr( "disabled" )
                }
                else
                {
                    h = $( "select[name=imgtype]" ).val();
                    var j = $( "input[name=goNewPath]:checked" ).length, k = $( "select[name=author]" ).val() == 1 ? "&author" : "";
                    $( "input[name=selFile]" ).val( g );
                    $( "input[name=newPathOK]" ).removeAttr( "disabled" );
                    $( "div#filemove" ).dialog( "close" );
                    if( j == 1 )
                    {
                        j = $( "span#path" ).attr( "title" );
                        $( "#imgfolder" ).load( nv_module_url + "folderlist&path=" + j + "&currentpath=" + b + "&random=" + nv_randomNum( 10 ) );
                        $( "#imglist" ).load( nv_module_url + "imglist&path=" + b + "&type=" + h + "&imgfile=" + g + k + "&num=" + +nv_randomNum( 10 ) )
                    }
                    else
                    {
                        $( "#imglist" ).load( nv_module_url + "imglist&path=" + a + "&type=" + h + "&imgfile=" + g + k + "&num=" + +nv_randomNum( 10 ) )
                    }
                }
            }
        }
        )
    }
}

//  ---------------------------------------

 );
$( "input[name=filerenameOK]" ).click( function()
{
    var a = $( "span#foldervalue" ).attr( "title" ), b = $( "input[name=selFile]" ).val(), d = $( "input[name=filerenameNewName]" ).val(), e = b.match( /^(.+)\.([a-zA-Z0-9]+)$/ );
    d = $.trim( d );
    $( "input[name=filerenameNewName]" ).val( d );
    if( d == "" )
    {
        alert( LANG.rename_noname );
        $( "input[name=filerenameNewName]" ).focus()
    }
    else
    {
        if( e[1] == d )
        {
            $( "div#filerename" ).dialog( "close" )
        }
        else
        {
            $( this ).attr( "disabled", "disabled" );
            $.ajax(
            {
                type:"POST", url:nv_module_url + "renameimg&num=" + nv_randomNum( 10 ), data:"path=" + a + "&file=" + b + "&newname=" + d, success:function( g )
                {
                    var h = g.split( "_" );
                    if( h[0] == "ERROR" )
                    {
                        alert( h[1] );
                        $( "input[name=filerenameOK]" ).removeAttr( "disabled" )
                    }
                    else
                    {
                        h = $( "select[name=imgtype]" ).val();
                        var j = $( "select[name=author]" ).val() == 1 ? "&author" : "";
                        $( "input[name=filerenameOK]" ).removeAttr( "disabled" );
                        $( "div#filerename" ).dialog( "close" );
                        $( "#imglist" ).load( nv_module_url + "imglist&path=" + a + "&type=" + h + "&imgfile=" + g + j + "&num=" + nv_randomNum( 10 ) )
                    }
                }
            }
            )
        }
    }
}

//  ---------------------------------------

 );
$( "img[name=myFile2]" ).dblclick( function()
{
    $( "div[title=createInfo]" ).find( "div" ).remove();
    var a = $( "input[name=origWidth]" ).val(), b = $( "input[name=origHeight]" ).val();
    c = calSize( a, b, 360, 230 );
    $( this ).width( c[0] ).height( c[1] );
    $( "input[name=newHeight]" ).val( b );
    $( "input[name=newWidth]" ).val( a ).select()
}

//  ---------------------------------------

 );