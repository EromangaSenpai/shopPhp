function GetClickedElem(elem){
    if(false != elem.className.indexOf('bg-primary'))
    {
        if(document.getElementsByClassName('bg-primary').length > 0)// first elem it's a li so we pass it
        {
            var activeElements = document.getElementsByClassName('bg-primary');

            for (var i = 0; i < activeElements.length;i++)
            {
                activeElements[i].removeAttribute('class');
            }
            elem.setAttribute('class','bg-primary');
        }
        else
            elem.setAttribute('class','bg-primary');
    }

}



function GetId(elem) {
    var date = new Date(new Date().getTime() + 30 * 1000);
    document.cookie = "id=" + elem.cells[0].innerText + ";" + "path=/; expires=" + date.toUTCString();
    GetClickedElem(elem);
}