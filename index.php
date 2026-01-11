<?php
include 'partials/web_header.php';
include 'database/db_conn.php';

function displayNovel($novel) {
    ?>
    <div class="group relative flex flex-col bg-white rounded-[2rem] p-3 transition-all duration-500 hover:shadow-[0_20px_50px_rgba(0,0,0,0.1)] hover:-translate-y-2 border border-transparent hover:border-gray-100">
        <div class="relative aspect-[3/4.5] rounded-[1.7rem] overflow-hidden shadow-md">
            <img src="<?= htmlspecialchars($novel['cover']) ?>" 
                 alt="<?= htmlspecialchars($novel['name']) ?>" 
                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
            
            <div class="absolute top-3 left-3">
                <span class="bg-white/90 backdrop-blur-md text-[#0F172A] text-[9px] font-black px-3 py-1 rounded-full uppercase tracking-tighter shadow-sm">
                    <?= htmlspecialchars($novel['category']) ?>
                </span>
            </div>
        </div>

        <div class="mt-4 px-2 pb-2">
            <h5 class="font-black text-sm text-[#0F172A] truncate leading-tight group-hover:text-teal-main transition-colors">
                <?= htmlspecialchars($novel['name']) ?>
            </h5>
            <p class="text-gray-400 text-[11px] font-bold mt-1 uppercase tracking-wide">
                By <?= htmlspecialchars($novel['author']) ?>
            </p>
        </div>
    </div>
    <?php
}

$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
?>

<section class="relative bg-[#F8FAFC] overflow-hidden py-10 lg:py-16">
    <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-teal-main/5 rounded-full blur-[100px] -mr-32 -mt-32"></div>
    <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-purple-500/5 rounded-full blur-[80px] -ml-24 -mb-24"></div>

    <div class="container mx-auto px-6 lg:px-12 relative z-10">
        <div class="grid lg:grid-cols-2 gap-10 items-center">
            <div class="text-center lg:text-left space-y-6">
                <div class="inline-flex items-center space-x-2 bg-white px-3 py-1.5 rounded-full shadow-sm border border-gray-100">
                    <span class="flex h-2 w-2 rounded-full bg-teal-main animate-pulse"></span>
                    <p class="text-[#0F172A] font-black tracking-widest text-[9px] uppercase">New stories every day</p>
                </div>
                
                <h2 class="text-4xl lg:text-7xl font-black leading-[1.0] text-[#0F172A] tracking-tight">
                    Read the <span class="text-teal-main">Unseen</span> <br class="hidden lg:block"> Stories.
                </h2>
                
                <p class="text-gray-500 text-base lg:text-lg leading-relaxed max-w-lg mx-auto lg:mx-0 font-medium">
                    Dive into a world of imagination with over 10 million curated novels. Your next favorite journey starts here.
                </p>
                
                <form method="GET" action="index.php" class="relative max-w-xl mx-auto lg:mx-0 group">
                    <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-teal-main transition-colors">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="search" 
                           placeholder="Search title, author..." 
                           class="w-full py-5 pl-14 pr-32 rounded-full bg-white shadow-lg focus:outline-none focus:ring-4 focus:ring-teal-main/10 text-gray-700 border-none transition-all placeholder:text-gray-400 font-bold text-sm"
                           value="<?= htmlspecialchars($search_query); ?>">
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-teal-main text-white px-6 py-3.5 rounded-full font-black text-[10px] uppercase tracking-widest hover:bg-teal-main transition-all">
                        Search
                    </button>
                </form>
            </div>

            <div class="relative hidden lg:block">
                <div class="relative glass-card p-6 rounded-[3rem] border border-white/40 shadow-xl bg-white/40 backdrop-blur-xl transform rotate-1">
                    <div class="text-center mb-4">
                        <h4 class="font-black text-lg text-[#0F172A]">Featured Novel</h4>
                    </div>
                    <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=600" 
                         alt="Featured" 
                         class="rounded-[2rem] shadow-xl w-full h-[380px] object-cover">
                </div>
            </div>
        </div>
    </div>
</section>

<div class="bg-white py-12 lg:py-20">
    <?php if ($search_query): ?>
        <section class="container mx-auto px-6 lg:px-12">
            <div class="flex items-end justify-between mb-16 border-b border-gray-100 pb-8">
                <div>
                    <p class="text-teal-main font-black uppercase text-xs tracking-widest mb-2">Results</p>
                    <h3 class="text-3xl lg:text-5xl font-black text-[#0F172A]">Found for "<?= htmlspecialchars($search_query); ?>"</h3>
                </div>
                <a href="index.php" class="text-gray-400 hover:text-red-500 font-black text-xs uppercase tracking-widest transition-colors mb-2">Clear</a>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-8 lg:gap-12">
                <?php
                $sql = "SELECT * FROM novels WHERE (name LIKE ? OR author LIKE ? OR category LIKE ?) AND isActive = 1";
                $stmt = $conn->prepare($sql);
                $st = "%" . $search_query . "%";
                $stmt->bind_param("sss", $st, $st, $st);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) { displayNovel($row); }
                } else {
                    echo "<div class='col-span-full py-20 text-center'><h4 class='text-gray-300 font-black text-2xl italic'>No stories found matching your search.</h4></div>";
                }
                ?>
            </div>
        </section>
    <?php else: ?>
        
        <section class="container mx-auto px-6 lg:px-12 mb-24">
            <div class="flex items-center justify-between mb-10">
                <h3 class="text-2xl lg:text-4xl font-black text-[#0F172A] tracking-tighter">
                    New Arrivals <span class="text-teal-main">—</span>
                </h3>
                <a href="all-novels.php" class="group flex items-center space-x-2 text-[#0F172A] font-black text-[10px] uppercase tracking-widest">
                    <span>View All</span>
                    <svg class="transform group-hover:translate-x-1 transition-transform" width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6 lg:gap-10">
                <?php
                $sql = "SELECT * FROM novels WHERE isActive = 1 ORDER BY novel_id DESC LIMIT 5";
                $res = $conn->query($sql);
                if ($res->num_rows > 0) {
                    while($row = $res->fetch_assoc()) { displayNovel($row); }
                }
                ?>
            </div>
        </section>

        <section class="container mx-auto px-6 lg:px-12 mb-24">
            <div class="flex items-center justify-between mb-10">
                <h3 class="text-2xl lg:text-4xl font-black text-[#0F172A] tracking-tighter">
                    Islamic Library <span class="text-teal-main">—</span>
                </h3>
                <a href="islamic.php" class="group flex items-center space-x-2 text-[#0F172A] font-black text-[10px] uppercase tracking-widest">
                    <span>Explore More</span>
                    <svg class="transform group-hover:translate-x-1 transition-transform" width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6 lg:gap-10">
                <?php
                $sql = "SELECT * FROM novels WHERE category = 'islamic' AND isActive = 1 LIMIT 5";
                $res = $conn->query($sql);
                if ($res->num_rows > 0) {
                    while($row = $res->fetch_assoc()) { displayNovel($row); }
                }
                ?>
            </div>
        </section>

        <section class="container mx-auto px-6 lg:px-12">
            <div class="flex items-center justify-between mb-10">
                <h3 class="text-2xl lg:text-4xl font-black text-[#0F172A] tracking-tighter">
                    Fictional Worlds <span class="text-teal-main">—</span>
                </h3>
                <a href="fictional.php" class="group flex items-center space-x-2 text-[#0F172A] font-black text-[10px] uppercase tracking-widest">
                    <span>Discover More</span>
                    <svg class="transform group-hover:translate-x-1 transition-transform" width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6 lg:gap-10">
                <?php
                $sql = "SELECT * FROM novels WHERE category = 'fictional' AND isActive = 1 LIMIT 5";
                $res = $conn->query($sql);
                if ($res->num_rows > 0) {
                    while($row = $res->fetch_assoc()) { displayNovel($row); }
                }
                ?>
            </div>
        </section>

    <?php endif; ?>
</div>

<section class="container mx-auto px-6 lg:px-12 py-12">
    <div class="bg-[#0F172A] rounded-[3rem] p-10 lg:p-20 text-center text-white relative overflow-hidden shadow-2xl border border-white/5">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-teal-main/10 rounded-full blur-[100px]"></div>
        <div class="relative z-10">
            <span class="inline-block bg-teal-main text-white px-5 py-1.5 rounded-full text-[9px] font-black uppercase tracking-[0.3em] mb-6 shadow-xl">
                Coming 2026
            </span>
            <h3 class="text-3xl lg:text-6xl font-black mb-6 leading-tight tracking-tighter">
                Unlock the <span class="text-teal-main">Elite</span> Library
            </h3>
            <p class="text-gray-400 text-base lg:text-lg max-w-xl mx-auto mb-10 font-medium">
                Ad-free reading, offline downloads, and exclusive access.
            </p>
            <form method="POST" action="notify.php" class="max-w-md mx-auto flex flex-col sm:flex-row gap-3">
                <input type="email" name="email" required placeholder="your@email.com" 
                       class="flex-grow bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:outline-none focus:ring-2 focus:ring-teal-main/20 font-bold placeholder:text-gray-500">
                <button type="submit" class="bg-teal-main text-white px-8 py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest hover:scale-105 transition-all">
                    Join Waitlist
                </button>
            </form>
        </div>
    </div>
</section>

<?php include 'partials/web_footer.php'; ?>