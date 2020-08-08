
function autocomplete(inp,tbl) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;

  //autocomplete_function(inp);
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;

      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      
      a.style.overflow = "auto";
      
      a.style.backgroundColor = "#ffffff";
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/

      //this.parentNode.appendChild(a);
      //this.parentNode.appendChild(a);
     document.body.appendChild(a);
      var ps = $(this).offset();
      var pw = $(this).width();
       $("#"+this.id + "autocomplete-list").css({"width": (pw+30)+"px","top": (ps.top+27)+"px","left": ps.left+"px",});


          $.ajax({ 
                url: "autocomplete/autocomplete_search.php" ,
                type: "POST",
                data: tbl+'&keyword='+val+'&input='+this.id,
            })
            .success(function(result) {
    
          var obj = jQuery.parseJSON(result);
              if(obj != ''){
                 if(obj.length > 40){a.style.height = "400px";}else{ a.style.height = (obj.length*41)+"px"; }
          $.each(obj, function(key, val) {
          b = document.createElement("DIV");
              b.innerHTML = val["label"];
          b.addEventListener("click", function(e) {
              //inp.value = this.getElementsByTagName("input")[0].value;
              var vx = this.getElementsByTagName("input")[0].value;
             // select_p(vx,inp.id);
              inp.value = vx;
              this.getElementsByTagName("input")[0].click();
              //check_product(vx);
             //alert(vx);
              closeAllLists();
          });
          a.appendChild(b);


        });
                }
            });
  });

  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });

}