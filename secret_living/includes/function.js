/**
 * Created by DSV-03 on 9/26/2017.
 */
function isValidEmail(email)
{
    return /^[a-z0-9]+([-._+][a-z0-9]+)*@([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,4}$/.test(email)
        && /^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/.test(email);
}

function isValidPhone(phone)
{
    if (phone.match(/^\d{10}$/)) {
        return true;
    }
    return false;
}

function validZip(zip,country)
{
    if(country=='USA')
    {
        if (zip.match(/^[0-9]{5}$/)) {
            return true;
        }
        return false;
    }
    else
    {
        zip=zip.toUpperCase();
        if (zip.match(/^[A-Z][0-9][A-Z][0-9][A-Z][0-9]$/)) {
            return true;
        }
        return false;
    }

}

function validSSN(ssn)
{
    if (ssn.match(/^(?!\b(\d)\1+\b)(?!123456789|219099999|078051120)(?!666|000|9\d{2})\d{3}(?!00)\d{2}(?!0{4})\d{4}$/)) {
        return true;
    }
    return false;
}
function addressCheck(address)
{
    address = address.toLowerCase();
    if (address.match(/^[a-zA-Z0-9-.#,\/] ?([a-zA-Z0-9-.#,\/]|[a-zA-Z0-9-.#,\/] )*[a-zA-Z0-9-.#,\/]$/)) {
        return true;
    }
    return false;
}

function isValidCity(city)
{
    var re = /^[a-zA-Z\u0080-\u024F\s\/\-\)\(\`\.\"\']+$/;
    return re.test(city);
}

/*
 Copy to ClipBoard
 */
function copyToClipboard(element)
{
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).val()).select();
    document.execCommand("copy");
    $temp.remove();
    alert("Copy To Clipboard");
    return false;
}