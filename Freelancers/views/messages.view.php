<?php require('./views/partials/head.php')?>
<?php require('./views/partials/nav.php');?>

<?php
$admin_result = $con->query("SELECT * FROM tb_admin");

// Fetch all clients with their names
$client_result = $con->query("SELECT UchatId, email, first_name,last_name FROM tb_clientusers");

$ChatId = isset($_GET['ChatId']) ? intval($_GET['ChatId']) : null;

$user_name = "";
if ($ChatId) {
    // Check if the ChatId exists in the client table
    $user_query = $con->query("SELECT first_name, last_name FROM tb_clientusers WHERE UchatId = $ChatId");

    if ($user_query->num_rows > 0) {
        // If found in clients
        $user_row = $user_query->fetch_assoc();
        $user_name = htmlspecialchars($user_row['first_name'] . ' ' . $user_row['last_name']);
    } else {
        // If not found in clients, check in the admin table
        $admin_query = $con->query("SELECT AdminId FROM tb_admin WHERE AdminId = $ChatId");

        if ($admin_query->num_rows > 0) {
            // If found in admin, just set the name as "Admin"
            $user_name = "Admin";
        }
    }
}
?>

<div class="Msg-main-container">
    <div class="cht-bx-container">
        <div class="F-Container">
            <span style='font-size:25px; margin:auto; font-weight:500;'><span style ="color:#99CCFF;">Flashbook</span> Chat</span>
            <section class='Ttle'>Admin</section>
            <?php while ($admin = $admin_result->fetch_assoc()): ?>
                <div class="card" onclick="startConversation(<?= intval($admin['adminID']) ?>)">
                    <section class="profile"><img src="../assets/blank-profile-picture-973460_1280.png" alt=""></section>
                    <section class="cardDetails">
                        <div class="cardName">Admin</div>
                        <section class="text" style='font-size:10px;'>view Conversation</section>
                    </section>
                </div>
            <?php endwhile; ?>
            
            <div style='height:50vh; overflow:auto;'>
                <section class='Ttle'>Users</section>
                <?php while ($client = $client_result->fetch_assoc()): ?>
                    <div class="card" onclick="startConversation(<?= intval($client['UchatId']) ?>)">
                        <section class="profile"><img src="../assets/blank-profile-picture-973460_1280.png" alt=""></section>
                        <section class="cardDetails">
                            <div class="cardTitle">User</div>
                            <div class="cardName"><?= htmlspecialchars($client['first_name'] . ' ' . $client['last_name']); ?></div>
                            <div class="cardEmail"><?= htmlspecialchars($client['email']); ?></div>
                            <section class="text" style='font-size:10px;'>view Conversation</section>
                        </section>
                    </div>
                <?php endwhile; ?>
            </div>
            
        </div>

        <div class="S-Container">
            <div class="headTitle" style='display:flex; align-items:center;font-size:20px;'>
            <div id="burger" style="cursor: pointer; margin-inline:10px;">
                &#9776; <!-- Unicode for burger icon -->
            </div>
                
            <?= $user_name ? "Chatting with: $user_name" : "Select a user to chat" ?></div>
            <div id="chat-box" class='chat-box'></div>
            <div class="chatField">
                <input id="message-input" type="text" style='height:30px;'>
                <button onclick="FsendMessage()">Send</button>
            </div>
        </div>
    </div>
</div>

<script>
function startConversation(chatId) {
    window.location.href = `?ChatId=${chatId}`;
}

function FsendMessage() {
    const messageInput = document.getElementById("message-input");
    const message = messageInput.value.trim();
    const ChatId = <?php echo json_encode($ChatId); ?>;
    const freelancerId = <?php echo json_encode($_SESSION['FchatId']); ?>;

    if (message === "") return;

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../php/freelancer-send-message.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    messageInput.value = "";
                    loadMessages();
                } else {
                    alert("Error: " + response.message);
                }
            } else {
                alert("Failed to send message: " + xhr.status + " " + xhr.statusText);
            }
        }
    };

    xhr.send(`ChatId=${ChatId}&message=${encodeURIComponent(message)}&userChatId=${freelancerId}`);
}

function loadMessages() {
    const ChatId = <?php echo json_encode($ChatId); ?>;
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `../php/freelancer_load_message.php?ChatId=${ChatId}`, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            const chatBox = document.getElementById("chat-box");
            chatBox.innerHTML = xhr.responseText;

            // Delay the scroll to allow DOM rendering to complete
            setTimeout(function() {
                chatBox.scrollTop = chatBox.scrollHeight;
            }, 100); // 100ms delay should be sufficient
        }
    };
    xhr.send();
}

window.onload = function() {
    loadMessages(); // Load messages on initial page load
    setInterval(loadMessages, 2000); // Automatically reload messages every 2 seconds
};


document.getElementById("burger").addEventListener("click", function() {
    const fContainer = document.querySelector(".F-Container");
    if (fContainer.style.display === "none" || fContainer.style.display === "") {
        fContainer.style.display = "block"; // Show the container
    } else {
        fContainer.style.display = "none"; // Hide the container
    }
});
document.getElementById("message-input").addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault(); 
            FsendMessage(); 
        }
    });
</script>

<?php require('./views/partials/popups.php')?>
<?php require('./views/partials/footer.php')?>
