<script>
document.querySelector('form').addEventListener('submit', function(e) {
  let fields = document.querySelectorAll('input[required]');
  for (let field of fields) {
    if (!field.value.trim()) {
      alert("Please fill in all required fields.");
      e.preventDefault();
      return false;
    }
  }
});

</script>
