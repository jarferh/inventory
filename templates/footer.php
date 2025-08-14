<footer class="footer footer-transparent d-print-none">
                <div class="container-xl">
                    <div class="row text-center align-items-center flex-row-reverse">
                        <div class="col-lg-auto ms-lg-auto">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    <a href="documentation.php" class="link-secondary">Documentation</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="help.php" class="link-secondary">Help</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    Copyright &copy; <?= date('Y') ?>
                                    <a href="." class="link-secondary">Samah Agrovet POS</a>.
                                    All rights reserved.
                                </li>
                                <li class="list-inline-item">
                                    Last updated: <span id="lastUpdated"><?= $CURRENT_TIME ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Core JS -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="assets/vendor/tabler/js/tabler.min.js"></script>
    <script src="assets/vendor/chartjs/chart.umd.min.js"></script>
    <script src="assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/datatables/dataTables.bootstrap5.min.js"></script>
    <script src="assets/js/dashboard.js"></script>
    <?php if (basename($_SERVER['PHP_SELF']) === 'customer.php'): ?>
    <script src="assets/js/customer.js"></script>
    <?php endif; ?>
</body>
</html>