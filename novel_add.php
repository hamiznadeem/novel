<?php
ob_start();
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: admin_login.php");
    exit();
}
include 'database/db_conn.php'; 
include 'partials/inc_header.php';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $author = trim($_POST['author']);
    $category = trim($_POST['category']);
    $isActive = isset($_POST['isActive']) ? 1 : 0;

    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($_FILES["cover"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (empty($name) || empty($author) || empty($category)) {
        $message = "Please fill in all required fields.";
        $messageType = 'error';
    } else {
        if (move_uploaded_file($_FILES["cover"]["tmp_name"], $target_file)) {
            $cover_path = $target_file;
            $sql = "INSERT INTO novels (name, author, category, cover, isActive) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $name, $author, $category, $cover_path, $isActive);
            if ($stmt->execute()) {
                $message = "Novel added successfully!";
                $messageType = 'success';
            } else {
                $message = "Error adding novel: " . $conn->error;
                $messageType = 'error';
            }
        } else {
            $message = "Sorry, there was an error uploading your file.";
            $messageType = 'error';
        }
    }
}
?>

<main class="relative lg:ml-64 pt-6 lg:pt-10 pb-10 min-h-screen bg-slate-50">
    <div class="px-6 lg:px-10">
        <h2 class="text-slate-800 font-bold text-2xl">Add New Novel</h2>
        <p class="text-gray-500 text-sm mb-8">Create a new entry in your novel library.</p>
        
        <?php if ($message): ?>
            <div class="mb-6 p-4 rounded-lg <?php echo $messageType === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <form action="novel_add.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Novel Title</label>
                    <input type="text" id="name" name="name" required class="w-full px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                </div>

                <div>
                    <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Author Name</label>
                    <input type="text" id="author" name="author" required class="w-full px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select id="category" name="category" required class="w-full px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                        <option value="">Select a category</option>
                        <option value="islamic">Islamic</option>
                        <option value="fictional">Fictional</option>
                        <option value="premium">Premium</option>
                    </select>
                </div>

                <div>
                    <label for="cover" class="block text-sm font-medium text-gray-700 mb-1">Cover Image</label>
                    <input type="file" id="cover" name="cover" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <div class="flex items-center">
                    <input id="isActive" name="isActive" type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="isActive" class="ml-2 block text-sm text-gray-900">Publish this novel immediately</label>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-darkblue text-white rounded-xl text-sm font-bold hover:bg-black transition">Add Novel</button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php 
include 'partials/inc_footer.php'; 
ob_end_flush();
?>
