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

// Get the search query from the URL
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
?>

<section class="py-16 lg:py-20 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 lg:px-12">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 mb-16">
            <div class="space-y-2">
                <h3 class="text-3xl lg:text-5xl font-black text-[#0F172A]">Fictional —</h3>
                <p class="text-gray-500 font-medium italic">Explore the latest stories from our fictional collection.</p>
            </div>

            <form method="GET" action="" class="relative w-full md:max-w-md group">
                <input type="text" name="search" 
                       placeholder="Search title or author..." 
                       value="<?= htmlspecialchars($search_query) ?>"
                       class="w-full py-4 pl-14 pr-6 rounded-2xl bg-white border-none shadow-xl shadow-gray-200/50 focus:ring-2 focus:ring-teal-main/20 text-gray-700 transition-all">
                
                <div class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-teal-main transition-colors">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>

                <?php if($search_query): ?>
                    <a href="?" class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black uppercase text-gray-400 hover:text-red-500 tracking-tighter">Clear</a>
                <?php endif; ?>
            </form>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6 lg:gap-10">
            <?php
            if ($search_query !== '') {
                $sql = "SELECT * FROM novels WHERE category = 'fictional' AND isActive = 1 AND (name LIKE ? OR author LIKE ?)";
                $stmt = $conn->prepare($sql);
                $search_param = "%" . $search_query . "%";
                $stmt->bind_param("ss", $search_param, $search_param);
            } else {
                $sql = "SELECT * FROM novels WHERE category = 'fictional' AND isActive = 1 ORDER BY novel_id DESC";
                $stmt = $conn->prepare($sql);
            }

            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    displayNovel($row);
                }
            } else {
                ?>
                <div class="col-span-full py-24 text-center">
                    <div class="bg-white inline-block p-12 rounded-[3rem] shadow-sm border border-dashed border-gray-200">
                        <div class="text-gray-200 mb-4 flex justify-center">
                            <svg width="60" height="60" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18 18.247 18.477 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h4 class="text-xl font-black text-[#0F172A] mb-2">No Novel Found</h4>
                        <p class="text-gray-500 font-medium">We couldn't find any active Fictional novels matching "<?= htmlspecialchars($search_query) ?>"</p>
                        <a href="?" class="mt-6 inline-block bg-teal-main/10 text-teal-main px-6 py-2 rounded-full font-bold text-sm hover:bg-teal-main hover:text-white transition-all">Clear Search</a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>

<?php
include 'partials/web_footer.php';
?>