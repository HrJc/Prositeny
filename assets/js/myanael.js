function dateToday()
{
	var today = new Date();
	var dd = String(today.getDate()).padStart(2, '0');
	var mm = String(today.getMonth() + 1).padStart(2, '0');
	var yyyy = today.getFullYear();
	return dd + '/' + mm + '/' + yyyy;
}

function formatDateUK(date)
{
	var reg = new RegExp("^([0-9]){4}-([0-9]){2}-([0-9]){2}?$");
    var result = reg.test(date);
    return result;
}

function convertirDateFrs(date)
{
	if(formatDateUK(date) == true && date != '0000-00-00')
	{
		var str = date.split('-');
		return str[2] + '/' + str[1] + '/' + str[0];
	}
	else
	{
		var retDate = dateToday();
		return retDate;
	}
}

function isValidMD5(v)
{
    var estMd5 = /^[a-fA-F0-9]{32}$/;
    return estMd5.test(v);
}

