</main>
</div> <!-- .app -->

<script>
function confirmLogout() {
  return confirm("Yakin mau logout?");
}

/* TOGGLE DAFTAR BARANG */
document.addEventListener("click", function(e){
  const btn = e.target.closest(".items-toggle");
  if(!btn) return;

  const id = btn.getAttribute("data-target");
  const row = document.getElementById(id);
  if(!row) return;

  row.classList.toggle("open");
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
