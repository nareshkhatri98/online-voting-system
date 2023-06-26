function showForm(formId) {
  var forms = document.getElementsByClassName('form');

  for (var i = 0; i < forms.length; i++) {
    if (forms[i].id === formId) {
      forms[i].style.display = 'block';
    } else {
      forms[i].style.display = 'none';
    }
  }
}
