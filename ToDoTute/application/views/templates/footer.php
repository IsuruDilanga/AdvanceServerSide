		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
		<script>
			document.addEventListener('DOMContentLoaded', function () {
				// Function to hide the alert after 5 seconds
				setTimeout(function() {
					var successAlert = document.getElementById('success-alert');
					var errorAlert = document.getElementById('error-alert');

					if (successAlert) {
						successAlert.style.display = 'none';
					}

					if (errorAlert) {
						errorAlert.style.display = 'none';
					}
				}, 1500); // 5000 milliseconds = 5 seconds
			});
		</script>
		</body>
</html>
