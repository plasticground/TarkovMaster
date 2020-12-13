<body>

<header>
    <h1 class="h absolute">Dashboard</h1>
</header>
<div class="flex-container bg-gradient">
    <div class="box  align-items-center flex-row">
        <div class="flex-column m-1 w-25 h-50">
            <div class="shadow bg-secondary border border-m h-100">
                <div class="flex-container">
                    <div class="h-100">
                        <p><a href="/dashboard" class="menu">Dashboard</a></p>
                        <p><a href="/tables" class="menu">Tables</a></p>
                    </div>
                    <form class="m-x-auto h-auto m-b-1 m-t-1" action="" method="post">
                        <button name="auth" value="logout" class="btn btn-l btn-main">Logout</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="shadow bg-secondary m-1 border border-m w-50 h-50">
            <div class="p-1">
                <h6 class="h m-0">Bot info</h6>
                <div class="h-100 overflow-auto">
                    <p>...</p>
                </div>
            </div>
        </div>

        <div class="shadow bg-secondary m-1 border border-m w-25 h-50">
            <div class="p-1">
                <h6 class="h m-0">Bot options</h6>
                <div class="h-100 overflow-auto">
                    <p>...</p>
                </div>
            </div>
        </div>

    </div>
</div>

</body>