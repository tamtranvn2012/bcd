function delete_product(id,name,author,url){
    var r=confirm("Delete Product : "+name+" ?");
if (r==true)
  {
    window.open(url+"/delete/?id="+id+"&names="+name+"&authors="+author,"_parent");
  }
}
