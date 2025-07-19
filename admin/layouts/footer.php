</div>
</div>

<script src="<?php echo BASE_URL; ?>dist-admin/js/scripts.js"></script>
<script src="<?php echo BASE_URL; ?>dist-admin/js/custom.js"></script>


<?php if(isset($error_message)): ?>
<script>
iziToast.error({
    message: '<?php echo $error_message; ?>',
    position: 'topRight',
    timeout: 4000,
    color: 'red',
    icon: 'fa fa-times',
});
</script>
<?php endif; ?>


<?php if(isset($success_message)): ?>
<script>
iziToast.success({
    message: '<?php echo $success_message; ?>',
    position: 'topRight',
    timeout: 3000,
    color: 'green',
    icon: 'fa fa-check',
});
</script>
<?php endif; ?>

<?php if(isset($_SESSION['success_message'])): ?>
<script>
iziToast.success({
    message: '<?php echo $_SESSION['success_message']; ?>',
    position: 'topRight',
    timeout: 3000,
    color: 'green',
    icon: 'fa fa-check',
});
</script>
<?php unset($_SESSION['success_message']); ?>
<?php endif; ?>


<?php if(isset($_SESSION['error_message'])): ?>
<script>
iziToast.success({
    message: '<?php echo $_SESSION['error_message']; ?>',
    position: 'topRight',
    timeout: 3000,
    color: 'red',
    icon: 'fa fa-times',
});
</script>
<?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

</body>
</html>