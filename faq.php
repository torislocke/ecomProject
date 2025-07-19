<?php include "header.php"; ?>

<!-- breadcrumb start -->
<div class="breadcrumb">
    <div class="container">
        <ul class="list-unstyled d-flex align-items-center m-0">
            <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
            <li class="ml_10 mr_10">
                <i class="fas fa-chevron-right"></i>
            </li>
            <li>FAQ</li>
        </ul>
    </div>
</div>
<!-- breadcrumb end -->

<main id="MainContent" class="content-for-layout">
    <div class="faq-section mt-100 overflow-hidden">
        <div class="faq-inner">
            <div class="container">
                <div class="section-header text-center">
                    <h2 class="section-heading">Frequently Asked Question</h2>
                    <p class="section-subheading">All your questions about Axion answered </p>
                </div>
                <div class="faq-container">
                    <div class="row">
                        <?php
                        $i=0;
                        $statement = $pdo->prepare("SELECT * FROM faqs");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                            $i++;
                            ?>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="faq-item rounded">
                                    <h2 class="faq-heading heading_18 collapsed d-flex align-items-center justify-content-between"
                                        data-bs-toggle="collapse" data-bs-target="#faq<?php echo $i; ?>">
                                        <?php echo $row['question']; ?>
                                        <span class="faq-heading-icon">
                                            <i class="fas fa-chevron-down"></i>
                                        </span>
                                    </h2>
                                    <div id="faq<?php echo $i; ?>" class="accordion-collapse collapse">
                                        <p class="faq-body text_14">
                                            <?php echo nl2br($row['answer']); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>         
</main>

<?php include "footer.php"; ?>