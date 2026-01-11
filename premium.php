<?php
    include 'partials/web_header.php';
    include 'database/db_conn.php';
?>

<section class="py-16 lg:py-24 bg-gray-50">
    <div class="container mx-auto px-4 lg:px-12 text-center">
        <div class="bg-[#0F172A] rounded-[2.5rem] lg:rounded-[4rem] p-10 lg:p-24 relative overflow-hidden shadow-2xl border border-white/5">
            
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-teal-main/20 rounded-full blur-[100px]"></div>
            <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-purple-600/10 rounded-full blur-[100px]"></div>

            <div class="relative z-10 space-y-8">
                <div class="inline-flex items-center gap-2 bg-teal-main/10 border border-teal-main/20 px-4 py-2 rounded-full">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-main opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-teal-main"></span>
                    </span>
                    <span class="text-teal-main text-[11px] font-black uppercase tracking-widest">Coming Soon</span>
                </div>

                <h2 class="text-4xl lg:text-7xl font-black text-white leading-tight">
                    Our <span class="text-teal-main">Premium Library</span> <br class="hidden lg:block"> is on the way!
                </h2>

                <div class="pt-6">
                    <a href="index.php" class="inline-block bg-teal-main text-[#0F172A] px-10 py-4 rounded-2xl font-black uppercase text-xs tracking-[0.2em] hover:scale-105 transition-all shadow-xl shadow-teal-main/20 active:scale-95">
                        Explore Free Novels
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
    include 'partials/web_footer.php';
?>