<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trekker Tours</title>
    <!-- Import layout -->
    <!-- For static pages, the components can be included directly -->
    <?php include '../../assets/components/layout.php'; ?>
    <script src="../../assets/js/toggleTheme.js" defer></script>
</head>

<body>
    <!-- Header -->
    <?php include '../../assets/components/header.php'; ?>

    <!-- Main Content -->
    <h1>Trekker Tours</h1>

    <div class="tour-overview">
        <div id="carouseltourIndicators" class="carousel slide to-carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouseltourIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouseltourIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouseltourIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="../../assets/img/img1.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="../../assets/img/img2.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="../../assets/img/img3.jpg" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouseltourIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouseltourIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="to-details">
            <div class="to-header">
                <h2 class="to-title">Best of Northern Italy</h2>
            </div>
            <div class="to-description">
                <p>Join us for an unforgettable journey through Northern Italy, where you will experience breathtaking landscapes, rich history, and vibrant culture.</p>
                <p><strong>Inclusions:</strong> Accommodation, meals, guided tours, and transportation.</p>
            </div>
            <div class="to-features">
                <div class="to-duration">
                    <a class="icon-link icon-link-hover" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week-fill" viewBox="0 0 16 16">
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5m9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5M8.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM3 10.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5m3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z" />
                        </svg>
                        Duration
                    </a>
                    <p>8 Days and 7 Nights</p>
                </div>
                <div class="to-price">
                    <a class="icon-link icon-link-hover" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bank2" viewBox="0 0 16 16">
                            <path d="M8.277.084a.5.5 0 0 0-.554 0l-7.5 5A.5.5 0 0 0 .5 6h1.875v7H1.5a.5.5 0 0 0 0 1h13a.5.5 0 1 0 0-1h-.875V6H15.5a.5.5 0 0 0 .277-.916zM12.375 6v7h-1.25V6zm-2.5 0v7h-1.25V6zm-2.5 0v7h-1.25V6zm-2.5 0v7h-1.25V6zM8 4a1 1 0 1 1 0-2 1 1 0 0 1 0 2M.5 15a.5.5 0 0 0 0 1h15a.5.5 0 1 0 0-1z" />
                        </svg>
                        Minimum Price
                    </a>
                    <p>$1200</p>
                </div>
                <div class="to-activity">
                    <a class="icon-link icon-link-hover" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-walking" viewBox="0 0 16 16">
                            <path d="M9.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0M6.44 3.752A.75.75 0 0 1 7 3.5h1.445c.742 0 1.32.643 1.243 1.38l-.43 4.083a1.8 1.8 0 0 1-.088.395l-.318.906.213.242a.8.8 0 0 1 .114.175l2 4.25a.75.75 0 1 1-1.357.638l-1.956-4.154-1.68-1.921A.75.75 0 0 1 6 8.96l.138-2.613-.435.489-.464 2.786a.75.75 0 1 1-1.48-.246l.5-3a.75.75 0 0 1 .18-.375l2-2.25Z" />
                            <path d="M6.25 11.745v-1.418l1.204 1.375.261.524a.8.8 0 0 1-.12.231l-2.5 3.25a.75.75 0 1 1-1.19-.914zm4.22-4.215-.494-.494.205-1.843.006-.067 1.124 1.124h1.44a.75.75 0 0 1 0 1.5H11a.75.75 0 0 1-.531-.22Z" />
                        </svg>
                        Activity Level
                    </a>
                    <p>Balanced</p>
                </div>
            </div>
            <button class="btn btn-primary tour-booking" type="button">Book Now</button>
        </div>
    </div>
    <div class="itinerary">
        <div>
            <h2>Day 1</h2>
            <p>
                Your Northern Italy adventure begins in Milan, the cosmopolitan capital of fashion and design. Upon arrival, you'll be welcomed with a guided orientation walk through the city’s historic center, including the iconic Duomo di Milano and the elegant Galleria Vittorio Emanuele II. The evening concludes with a group welcome dinner featuring Lombard specialties like risotto alla Milanese.
            </p>
        </div>
        <div>
            <h2>Day 2</h2>
            <p>
                After breakfast, we head to Lake Como, renowned for its stunning scenery and charming villages. Enjoy a boat ride on the lake, visiting Bellagio and Varenna. In the afternoon, explore the gardens of Villa Carlotta before returning to Milan for an evening at leisure.
            </p>
        </div>
        <div>
            <h2>Day 3</h2>
            <p>
                Departing Milan, we travel to the picturesque town of Verona, famous for its Shakespearean connections. Visit Juliet's House and the ancient Roman amphitheater. After lunch, continue to Venice, where you'll enjoy a gondola ride through the city's enchanting canals.
            </p>
        </div>
    </div>
    <!-- Footer -->
</body>

</html>