<?php
    include 'partials/web_header.php';
?>

<section class="py-16 lg:py-18 bg-gray-50">
    <div class="container mx-auto px-4 lg:px-12">
        <h3 class="text-3xl lg:text-4xl font-[900] text-center mb-12 lg:mb-16 text-teal-main">Contact Us —</h3>
        
        <div class="max-w-xl mx-auto">
            <?php if (isset($_GET['success'])): ?>
                <div class="mb-6 p-4 rounded-lg bg-green-100 text-green-700">
                    Message sent successfully!
                </div>
            <?php endif; ?>
            <form method="POST" action="contact.php" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Your Email</label>
                    <input type="email" id="email" name="email" required class="w-full px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                </div>
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                    <textarea id="message" name="message" rows="4" required class="w-full px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 outline-none transition"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-darkblue text-white rounded-xl text-sm font-bold hover:bg-black transition">Send Message</button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php
    include 'partials/web_footer.php';
?>
