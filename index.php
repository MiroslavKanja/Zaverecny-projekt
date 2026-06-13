<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'app/Database.php';
require_once 'app/Device.php';

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
            <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #64748b; font-weight: 600;">
                Momentálne nie je v databáze evidovaná žiadna technika.
            </div>
        <?php else: ?>
            <?php foreach ($devices as $device): ?>
                <div class="card">
                    <h3><?php echo htmlspecialchars($device['name'], ENT_QUOTES, 'UTF-8'); ?></h3>

                    <?php if ($device['status'] === 'available'): ?>
                        <p class="status available">Dostupné</p>

                        <?php if (isset($_SESSION['user_id'])): ?>
                            <button class="btn" onclick="window.location.href='rent-device.php?id=<?php echo $device['id']; ?>'">Požičať si</button>
                        <?php else: ?>
                            <button class="btn" onclick="alert('Pre zapožičanie techniky sa musíte najskôr prihlásiť!'); window.location.href='login.php';">Požičať si</button>
                        <?php endif; ?>

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