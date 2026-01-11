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

$novel_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($novel_id <= 0) {
    header("Location: dashboard.php");
    exit();
}

$sql = "SELECT * FROM novels WHERE novel_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $novel_id);
$stmt->execute();
$result = $stmt->get_result();
$novel = $result->fetch_assoc();

if (!$novel) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $author = trim($_POST['author']);
    $category = trim($_POST['category']);
    $isActive = isset($_POST['isActive']) ? 1 : 0;

    $cover_path = $novel['cover'];

    if (!empty($_FILES["cover"]["name"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["cover"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (move_uploaded_file($_FILES["cover"]["tmp_name"], $target_file)) {
            $cover_path = $target_file;
        } else {
            $message = "Sorry, there was an error uploading your file.";
            $messageType = 'error';
        }
    }

    if (empty($message)) {
        if (empty($name) || empty($author) || empty($category)) {
            $message = "Please fill in all required fields.";
            $messageType = 'error';
        } else {
            $sql = "UPDATE novels SET name = ?, author = ?, category = ?, cover = ?, isActive = ? WHERE novel_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssii", $name, $author, $category, $cover_path, $isActive, $novel_id);
            if ($stmt->execute()) {
                $message = "Novel updated successfully!";
                $messageType = 'success';
                // Refresh the novel data
                $sql = "SELECT * FROM novels WHERE novel_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $novel_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $novel = $result->fetch_assoc();
            } else {
                $message = "Error updating novel: " . $conn->error;
                $messageType = 'error';
            }
        }
    }
}
?>

<main class="relative lg:ml-64 pt-6 lg:pt-10 pb-10 min-h-screen bg-slate-50">
    <div class="px-6 lg:px-10">
        <h2 class="text-slate-800 font-bold text-2xl">Edit Novel</h2>
        <p class="text-gray-500 text-sm mb-8">Update the details of the novel.</p>
        
        <?php if ($message): ?>
            <div class="mb-6 p-4 rounded-lg <?php echo $messageType === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <form action="novel_edit.php?id=<?php echo $novel_id; ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Novel Title</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($novel['name']); ?>" required class="w-full px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                </div>

                <div>
                    <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Author Name</label>
                    <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($novel['author']); ?>" required class="w-full px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select id="category" name="category" required class="w-full px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                        <option value="">Select a category</option>
                        <option value="islamic" <?php echo $novel['category'] === 'islamic' ? 'selected' : ''; ?>>Islamic</option>
                        <option value="fictional" <?php echo $novel['category'] === 'fictional' ? 'selected' : ''; ?>>Fictional</option>
                        <option value="premium" <?php echo $novel['category'] === 'premium' ? 'selected' : ''; ?>>Premium</option>
                    </select>
                </div>

                <div>
                    <label for="cover" class="block text-sm font-medium text-gray-700 mb-1">Cover Image</label>
                    <input type="file" id="cover" name="cover" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <?php if (!empty($novel['cover'])): ?>
                        <div class="mt-4">
                            <img src="<?php echo htmlspecialchars($novel['cover']); ?>" class="w-20 h-auto rounded-md shadow-sm border border-gray-100">
                        </div>
                    <?php endif; ?>
                </div>

                <div class="flex items-center">
                    <input id="isActive" name="isActive" type="checkbox" <?php echo $novel['isActive'] ? 'checked' : ''; ?> class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="isActive" class="ml-2 block text-sm text-gray-900">Publish this novel</label>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-darkblue text-white rounded-xl text-sm font-bold hover:bg-black transition">Update Novel</button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php 
include 'partials/inc_footer.php'; 
ob_end_flush();
?>
