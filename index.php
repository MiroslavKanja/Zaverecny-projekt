<?php 
    
    include_once 'parts/header.php'; 
?>

<section class="hero">
    <h1>Dostupná technika</h1>
    <p>Prehľad zariadení, ktoré sú momentálne k dispozícii na zapožičanie.</p>
</section>

<div class="grid">
    <div class="card">
        <h3>Notebook Lenovo L480</h3>
        <p class="status available">Dostupné</p>
        <button class="btn">Požičať si</button>
    </div>

    <div class="card">
        <h3>Projektor Epson EB-X05</h3>
        <p class="status busy">Vypožičané</p>
        <button class="btn" disabled>Nedostupné</button>
    </div>

    <div class="card">
        <h3>Grafický tablet Wacom</h3>
        <p class="status available">Dostupné</p>
        <button class="btn">Požičať si</button>
    </div>
</div>
<?php 
    
    include_once 'parts/footer.php'; 
?>