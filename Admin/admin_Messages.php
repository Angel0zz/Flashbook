<?php require('./adminComponents/Admin-head.php'); ?>
<?php
$chatId = isset($_GET['chatId']) ? intval($_GET['chatId']) : null;
$freelancer_result = $con->query("SELECT * FROM tb_freelancers WHERE status ='Active'");
$client_result = $con->query("SELECT * FROM tb_clientusers");

// Initialize the user name variable
$user_name = "";
if ($chatId) {
    // First, check if the chatId belongs to a client
    $user_query = $con->query("SELECT first_name, last_name FROM tb_clientusers WHERE UchatId = $chatId");
    
    if ($user_query->num_rows > 0) {
        $user_row = $user_query->fetch_assoc();
        $user_name = htmlspecialchars($user_row['first_name'] . ' ' . $user_row['last_name']);
    } else {
        // If no client found, check if the chatId belongs to a freelancer
        $user_query = $con->query("SELECT fname, last_name FROM tb_freelancers WHERE FchatId = $chatId");
        
        if ($user_query->num_rows > 0) {
            $user_row = $user_query->fetch_assoc();
            $user_name = htmlspecialchars($user_row['fname'] . ' ' . $user_row['last_name']);
        }
    }
}

?>

<div class="wrapper">
    <?php require('./adminComponents/Admin-sideBar.php'); ?>
    <div class="main">
        <div class="header">
            <section class='burger' id="toggleSidebar">
                <div></div>
                <div></div>
                <div></div> 
            </section>
            <section class="Title"><span>Messages</span></section>
        </div>

        <div class="Msg-main-container">
            <div class="cht-bx-container">
                <div class="F-Container">
                    <span style='font-size:25px; margin:auto; font-weight:500;'><span style ="color:#99CCFF;">Flashbook</span> Chat</span>
                    <section class='Ttle'>Clients</section>
                    <?php while ($client = $client_result->fetch_assoc()): ?>
                        <div class="card" onclick="startConversation(<?= intval($client['UchatId']) ?>, '<?= htmlspecialchars($client['first_name'] . ' ' . $client['last_name']) ?>')">
                            <section class="profile"><img src="../assets/blank-profile-picture-973460_1280.png" alt=""></section>
                            <section class="cardDetails">
                                <div class="cardTitle">Client</div>
                                <div class="cardName"><?= htmlspecialchars($client['email']) ?></div>
                                <section class="text" style='font-size:10px;'>view Conversation</section>
                            </section>
                        </div>
                    <?php endwhile; ?>

                    <section class='Ttle'>Freelancers</section>
                    <?php while ($freelancer = $freelancer_result->fetch_assoc()): ?>
                        <div class="card" onclick="startConversation(<?= intval($freelancer['FchatId']) ?>, '<?= htmlspecialchars($freelancer['fname'] . ' ' . $freelancer['last_name']) ?>')">
                            <section class="profile"><img src="../assets/blank-profile-picture-973460_1280.png" alt=""></section>
                            <section class="cardDetails">
                                <div class="cardTitle">Freelancer</div>
                                <div class="cardName"><?= htmlspecialchars($freelancer['fname'] . ' ' . $freelancer['last_name']); ?></div>
                                <section class="text" style='font-size:10px;'>view Conversation</section>
                            </section>
                        </div>
                    <?php endwhile; ?>
                </div>

                <div class="S-Container">
                    <div class="headTitle" style='display:flex; align-items:center; font-size:20px;'>
                        <div id="burger" style="cursor: pointer; margin-inline:10px;">&#9776;</div>
                        <div id="current-user"><?= $user_name ? "Chatting with: $user_name" : "Select a user to chat" ?></div>
                    </div>
                    <div id="chat-box" class='chat-box'></div>
                    <div class="chatField">
                        <input id="message-input" type="text" style='height:30px;'>
                        <button onclick="sendMessage()">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function closeError() {
    document.getElementById('errorContainer').style.display = 'none';
}
function closeSuccess() {
    document.getElementById('successContainer').style.display = 'none';
}
setTimeout(closeError, 3000);
setTimeout(closeSuccess, 3000);

document.getElementById('toggleSidebar').addEventListener('click', function() {
    document.querySelector('.wrapper').classList.toggle('collapse');
});

function startConversation(chatId, userName) {
    document.getElementById("current-user").innerText = `Chatting with: ${userName}`;
    window.location.href = `?chatId=${chatId}`;
}

function sendMessage() {
    const messageInput = document.getElementById("message-input");
    const message = messageInput.value.trim();
    const chatId = <?php echo json_encode($chatId); ?>;
    const adminChatID = <?php echo json_encode($_SESSION['adminID']); ?>;
    if (message === "") return;
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../php/admin_send_message.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                messageInput.value = "";
                loadMessages();
            } else {
                alert("Failed to send message: " + xhr.status + " " + xhr.statusText);
            }
        }
    };

    xhr.send(`chatId=${chatId}&message=${encodeURIComponent(message)}&adminChatID=${adminChatID}`);
}

function loadMessages() {
    const chatId = <?php echo json_encode($chatId); ?>;
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `../php/load_admin_messages.php?chatId=${chatId}`, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            const chatBox = document.getElementById("chat-box");
            chatBox.innerHTML = xhr.responseText;

            // Delay the scroll to allow DOM rendering to complete
            setTimeout(function() {
                chatBox.scrollTop = chatBox.scrollHeight;
            }, 100);
        }
    };
    xhr.send();
}

window.onload = function() {
    loadMessages();
    setInterval(loadMessages, 2000); // Automatically reload messages every 2 seconds
};
</script>
</body>
</html>
