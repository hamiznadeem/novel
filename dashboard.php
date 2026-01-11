<?php
ob_start();
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: admin_login.php");
    exit();
}
include 'database/db_conn.php';
include 'partials/inc_header.php';

// messages
$message = '';
$messageType = '';

// Handle GET actions
if (isset($_GET['action'], $_GET['id'])) {
    $action = $_GET['action'];
    $id = intval($_GET['id']);
    if ($id > 0) {
        if ($action === 'block') {
            $sql = "UPDATE novels SET isActive = CASE WHEN isActive = 1 THEN 0 ELSE 1 END WHERE novel_id={$id} LIMIT 1";
            mysqli_query($conn, $sql);
            header('Location:' . $_SERVER['PHP_SELF']);
            exit;
        }
        if ($action === 'delete') {
            $sql = "DELETE FROM novels WHERE novel_id={$id} LIMIT 1";
            mysqli_query($conn, $sql);
            header('Location:' . $_SERVER['PHP_SELF']);
            exit;
        }
    }
}

$where = [];
$status = isset($_GET['status']) ? $_GET['status'] : 'all';
if ($status !== 'all') {
    $safe_status = mysqli_real_escape_string($conn, $status);
    $where[] = "category='{$safe_status}'";
}

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
if ($q !== '') {
    $safe_q = mysqli_real_escape_string($conn, $q);
    $where[] = "(name LIKE '%{$safe_q}%' OR author LIKE '%{$safe_q}%')";
}

$where_sql = '';
if (count($where) > 0) $where_sql = 'WHERE ' . implode(' AND ', $where);

$sql = "SELECT * FROM novels {$where_sql} ORDER BY novel_id DESC";
$result = mysqli_query($conn, $sql);
?>



<main class="relative lg:ml-64 pt-6 lg:pt-10 pb-10 min-h-screen bg-slate-50">
    
    <div class="px-6 lg:px-10 mb-8">
        <h2 class="text-slate-800 font-bold text-2xl">Welcome, <?php echo $_SESSION['username']; ?>!</h2>
        <p class="text-gray-500 text-sm">Manage your novel library and visibility.</p>
    </div>

    <div class="px-6 lg:px-10 mb-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex justify-between items-center">
            <div>
                <h3 class="text-gray-400 text-xs font-bold uppercase tracking-wider">Total Library</h3>
                <p class="text-3xl font-bold text-darkblue"><?php echo mysqli_num_rows($result); ?> <span class="text-sm font-normal text-gray-400">Novels</span></p>
            </div>
            <div class="p-3 bg-darkblue rounded-xl text-white">
                <i data-lucide="book-open" class="w-8 h-8"></i>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex justify-between items-center">
            <div>
                <h3 class="text-gray-400 text-xs font-bold uppercase tracking-wider">Total Categories</h3>
                <?php
                    $sql_cat = "SELECT COUNT(DISTINCT category) as cat_count FROM novels";
                    $cat_result = mysqli_query($conn, $sql_cat);
                    $cat_row = mysqli_fetch_assoc($cat_result);
                ?>
                <p class="text-3xl font-bold text-darkblue"><?php echo $cat_row['cat_count']; ?> <span class="text-sm font-normal text-gray-400">Categories</span></p>
            </div>
            <div class="p-3 bg-darkblue rounded-xl text-white">
                <i data-lucide="folder" class="w-8 h-8"></i>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex justify-between items-center">
            <div>
                <h3 class="text-gray-400 text-xs font-bold uppercase tracking-wider">Total Authors</h3>
                <?php
                    $sql_auth = "SELECT COUNT(DISTINCT author) as auth_count FROM novels";
                    $auth_result = mysqli_query($conn, $sql_auth);
                    $auth_row = mysqli_fetch_assoc($auth_result);
                ?>
                <p class="text-3xl font-bold text-darkblue"><?php echo $auth_row['auth_count']; ?> <span class="text-sm font-normal text-gray-400">Authors</span></p>
            </div>
            <div class="p-3 bg-darkblue rounded-xl text-white">
                <i data-lucide="users" class="w-8 h-8"></i>
            </div>
        </div>
    </div>

    <div class="px-6 lg:px-10 pb-10 space-y-6">

        <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6">
            <div class="bg-darkblue text-white p-1 rounded-xl flex overflow-x-auto no-scrollbar w-full xl:w-auto">
                <a href="dashboard.php?status=all" class="px-5 py-2 <?php echo $status==='all' ? 'bg-white text-darkblue shadow-sm' : 'text-white hover:bg-white hover:text-darkblue'; ?> rounded-lg text-xs font-bold transition whitespace-nowrap">All</a>
                <a href="dashboard.php?status=islamic" class="px-5 py-2 <?php echo $status==='islamic' ? 'bg-white text-darkblue shadow-sm' : 'text-white hover:bg-white hover:text-darkblue'; ?> rounded-lg text-xs font-bold transition whitespace-nowrap">Islamic</a>
                <a href="dashboard.php?status=fictional" class="px-5 py-2 <?php echo $status==='fictional' ? 'bg-white text-darkblue shadow-sm' : 'text-white hover:bg-white hover:text-darkblue'; ?> rounded-lg text-xs font-bold transition whitespace-nowrap">Fictional</a>
                <a href="dashboard.php?status=premium" class="px-5 py-2 <?php echo $status==='premium' ? 'bg-white text-darkblue shadow-sm' : 'text-white hover:bg-white hover:text-darkblue'; ?> rounded-lg text-xs font-bold transition whitespace-nowrap">Premium</a>
            </div>

            <form method="GET" action="dashboard.php" class="flex gap-2 w-full xl:w-auto">
                <input type="hidden" name="status" value="<?php echo htmlspecialchars($status); ?>">
                <div class="relative flex-1 sm:w-64">
                    <input type="text" name="q" value="<?php echo htmlspecialchars($q); ?>" placeholder="Search novels..." class="w-full pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                    <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
                </div>
                <button type="submit" class="px-5 py-2 bg-darkblue text-white rounded-xl text-sm font-bold hover:bg-black transition">Search</button>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="overflow-visible"> 
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50/50 text-gray-400 font-bold uppercase text-[10px] tracking-widest border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Novel Details</th>
                            <th class="px-6 py-4">Author</th>
                            <th class="px-6 py-4">Cover</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <?php if ($result && mysqli_num_rows($result) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4 font-mono text-xs text-gray-400">#<?php echo $row['novel_id']; ?></td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800"><?php echo htmlspecialchars($row['name']); ?></div>
                                    <div class="text-[10px] text-gray-400 uppercase tracking-tighter"><?php echo htmlspecialchars($row['category'] ?? 'General'); ?></div>
                                </td>
                                <td class="px-6 py-4 text-gray-600"><?php echo htmlspecialchars($row['author']); ?></td>
                                
                                <td class="px-6 py-4">
                                    <div class="w-10 h-14 rounded-md shadow-sm border border-gray-100 overflow-hidden bg-slate-100">
                                        <?php if(!empty($row['cover'])): ?>
                                            <img src="<?php echo htmlspecialchars($row['cover']); ?>" class="w-full h-full object-cover" alt="cover">
                                        <?php else: ?>
                                            <div class="w-full h-full flex items-center justify-center"><i data-lucide="book" class="w-4 h-4 text-gray-300"></i></div>
                                        <?php endif; ?>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <?php if ($row['isActive']): ?>
                                        <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span> Active
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span> Hidden
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <div class="dropdown dropdown-end ">
                                        <button tabindex="0" role="button" class="btn p-2 hover:bg-gray-100 rounded-lg text-gray-400 transition">
                                            <i data-lucide="more-horizontal" class="w-5 h-5"></i>
                                        </button>
                                        
                                        <div class="dropdown-menu">
                                                <ul tabindex="-1" class="dropdown-content menu">
                                                    <li>
                                                        <a href="novel_edit.php?id=<?php echo $row['novel_id']; ?>" class="flex items-center gap-2 px-4 py-2 text-xs font-semibold text-red-600 hover:bg-red-50">
                                                            <i data-lucide="edit" class="w-4 h-4"></i> Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="?action=block&id=<?php echo $row['novel_id']; ?>" class="flex items-center gap-2 px-4 py-2 text-xs font-semibold <?php echo $row['isActive'] ? 'text-orange-600 hover:bg-orange-50' : 'text-green-600 hover:bg-green-50'; ?>">
                                                            <i data-lucide="<?php echo $row['isActive'] ? 'eye-off' : 'eye'; ?>" class="w-4 h-4"></i>
                                                            <?php echo $row['isActive'] ? 'Hide Novel' : 'Publish'; ?>
                                                        </a>
                                                    </li>
                                                    <div class="border-t border-gray-50"></div>
                                                    <li>
                                                        <a href="?action=delete&id=<?php echo $row['novel_id']; ?>" onclick="return confirm('Are you sure you want to delete this novel? This action cannot be undone.')" class="flex items-center gap-2 px-4 py-2 text-xs font-semibold text-red-600 hover:bg-red-50">
                                                            <i data-lucide="trash-2" class="w-4 h-4"></i> Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center opacity-20">
                                        <i data-lucide="book-x" class="w-12 h-12 mb-2"></i>
                                        <p class="font-bold">No novels found here.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>



<?php 
include 'partials/inc_footer.php'; 
ob_end_flush();
?>