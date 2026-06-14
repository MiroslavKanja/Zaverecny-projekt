<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'app/Database.php';
require_once 'app/Device.php';

$deviceModel = new Device();
$devices = $deviceModel->getAllDevices();


$my_borrowings = [];
if (isset($_SESSION['user_id'])) {
    $db = Database::getInstance()->getConnection();

    // Vytiahneme len tie zariadenia, ktoré má požičané prihlásený človek a ešte ich nevrátil (returned_at IS NULL)
    $stmt_my = $db->prepare("
        SELECT b.id AS borrowing_id, d.name, b.borrowed_at 
        FROM borrowings b
        JOIN devices d ON b.device_id = d.id
        WHERE b.user_id = :user_id AND b.returned_at IS NULL
    ");
    $stmt_my->execute(['user_id' => $_SESSION['user_id']]);
    $my_borrowings = $stmt_my->fetchAll(PDO::FETCH_ASSOC);
}

include_once 'parts/header.php';
?>

    <section class="hero">
        <h1>Dostupná technika</h1>
        <p>Prehľad zariadení, ktoré sú momentálne k dispozícii na zapožičanie.</p>
    </section>

<?php if (isset($_SESSION['user_id']) && !empty($my_borrowings)): ?>
    <div style="max-width: 1200px; margin: 30px auto; padding: 0 20px;">
        <h2 style="margin-bottom: 15px; color: #1e293b;">Moje aktuálne výpožičky</h2>
        <table style="width: 100%; border-collapse: collapse; background: #ffffff; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden;">
            <thead>
            <tr style="background: #f1f5f9; text-align: left; border-bottom: 2px solid #e2e8f0;">
                <th style="padding: 14px; color: #475569;">Názov zariadenia</th>
                <th style="padding: 14px; color: #475569;">Dátum a čas vypožičania</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($my_borrowings as $borrow): ?>
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 14px; font-weight: 600; color: #0f172a;"><?php echo htmlspecialchars($borrow['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td style="padding: 14px; color: #64748b;"><?php echo date('d.m.Y H:i', strtotime($borrow['borrowed_at'])); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <hr style="max-width: 1160px; margin: 20px auto; border: 0; border-top: 1px solid #e2e8f0;">
<?php endif; ?>

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