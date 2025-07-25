<?php include 'layouts/top.php'; ?>



<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Create Product</h1>
            <form method="POST" action="add_coffee.php" enctype="multipart/form-data">
                <label>Coffee Name:
                    <input type="text" name="coffee_name" required>
                </label><br>

                <label>12-Ounce Bag:
                    <input type="hidden" name="size_1" value="12-ounce bag" required>
                </label>
                <label>Price:
                    <input type="number" name="price_1" step="0.01" required>
                </label><br>

                <label>2-Pound Bag:
                    <input type="hidden" name="size_2" value="2-pound bag" required>
                </label>
                <label>Price:
                    <input type="number" name="price_2" step="0.01" required>
                </label><br>

                <label>Photo:
                    <input type="file" name="coffee_image" accept="image/*" required>
                </label><br>

                <button type="submit">Save Coffee</button>
            </form>
        </div>
    </section>
    <?php include 'layouts/footer.php'; ?>