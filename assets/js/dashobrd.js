// Sidebar Toggle
var sidebarOpen = false;
var sidebar = document.getElementById("sidebar");

function openSidebar(){
  if(!sidebarOpen){
    sidebar.classList.add("sidebar-reponsive");
    sidebarOpen = true;
  } 
}

function closeSidebar(){
  if(sidebarOpen){
    sidebar.classList.remove("sidebar-reponsive")
    sidebarOpen = false;
}
}