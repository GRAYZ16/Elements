$('#infoModal').on('show.bs.modal', function (e) {
  var $invoker = $(e.relatedTarget);

  var mac_address = $invoker.children("div").children("p.card-subtitle").html();

  $('#btnExport').attr("href", "index.php?request=export&addr=" + mac_address)

  getDevice(mac_address);
});

function getDevice(str) {
    if (str == "")
    {
        return;
    }
    else
    {
        if (window.XMLHttpRequest)
        {
            xmlhttp = new XMLHttpRequest();
        }
        else
        {
          xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("infoModalContent").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","index.php?request=getDevice&addr="+str,true);
        xmlhttp.send();
    }
}
