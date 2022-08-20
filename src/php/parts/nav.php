<nav class="header">
    <ul>
        <li><a href="/"><img src="/media/logo.png" alt="Gishamer Logo"></a></li>

        <div class="navSearch">
            <input id="nav-search" type="text" name="search" autocomplete="off" placeholder="Suche">
            <ul id="search-results">

            </ul>
        </div>

        <li><a href="/">Home</a></li>
        <?php
        if (userIsLoggedIn()) {
        ?>
            <li><a href="/admin/">Admin</a></li>
            <li><a href="/logout.php">Logout</a></li>
        <?php } else { ?>
            <li><a href="/login.php">Login</a></li>
        <?php
        }
        ?>
    </ul>
</nav>

<script>
    const searchField = document.getElementById('nav-search');
    searchField.addEventListener('input', searchDb);

    function searchDb(e) {
        //search in DB and show results in dropdown
        //get results as json
        let results = [];
        const input = e.target.value.trim();
        var ul = document.getElementById("search-results");

        if (input == '') {
            ul.innerHTML = '';
        } else {
            fetch("search.php?term=" + input)
                .then(
                    response => response.json()
                )
                .then(
                    results => {
                        ul.innerHTML = "";
                        results.forEach(element => {
                            var li = document.createElement("li");
                            var resultElement = document.createElement("div");
                            var containerDiv = document.createElement("div");
                            var title = document.createTextNode(element.title);
                            var icon = document.createElement("img");

                            if (element.link) {
                                // containerDiv
                                icon.src = "/media/icon_document-filled.svg";
                                containerDiv.addEventListener("click", function(evnt) {
                                    SpawnDialog(element.title, element.link, element.info, element.color, element.thumbnail)
                                });
                            } else {
                                //TODO: add specific icon
                                icon.src = "/media/icon_folder-filled.svg";
                                containerDiv.addEventListener("click", function(evnt) {
                                    if (element.type == "main_category") {
                                        window.location.href = "/category.php?cid=" + element.id;
                                    } else {
                                        window.location.href = "/category.php?cid=" + element.main_category_id;
                                    }
                                });
                            }
                            containerDiv.appendChild(icon);
                            containerDiv.appendChild(title);
                            li.appendChild(containerDiv);
                            ul.appendChild(li);
                        });
                    }
                )
        }


    }
</script>