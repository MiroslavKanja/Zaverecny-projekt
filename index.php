<?php
// Ručné načítanie našich OOP tried (bez Composera)
require_once 'app/Database.php';
require_once 'app/Device.php';

// Inicializácia triedy Device a vytiahnutie techniky z databázy
$deviceModel = new Device();
$devices = $deviceModel->getAllDevices();

include_once 'parts/header.php';
?>

    <section class="hero">
        <h1>Dostupná technika</h1>
        <p>Prehľad zariadení, ktoré sú momentálne k dispozícii na zapožičanie.</p>
    </section>

    <div class="grid">
        <?php if (empty($devices)): ?>
            <p>Momentálne sa v systéme nenachádza žiadna technika.</p>
        <?php else: ?>
            <?php foreach ($devices as $device): ?>
                <div class="card">
                    <h3><?php echo htmlspecialchars($device['name'], ENT_QUOTES, 'UTF-8'); ?></h3>

                    <?php if ($device['status'] === 'available'): ?>
                        <p class="status available">Dostupné</p>
                        <button class="btn">Požičať si</button>
                    <?php else: ?>
                        <p class="status busy">Vypožičané</p>
                        <button class="btn" disabled>Nedostupné</button>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

<?php
include_once 'parts/footer.php';
?>