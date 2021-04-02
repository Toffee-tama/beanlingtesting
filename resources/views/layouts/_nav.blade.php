<nav class="navbar navbar-expand-md navbar-dark bg-dark" id="headerNav">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('lorekeeper.settings.site_name', 'Lorekeeper') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    @if(Auth::check() && Auth::user()->is_news_unread && Config::get('lorekeeper.extensions.navbar_news_notif'))
                        <a class="nav-link d-flex text-warning" href="{{ url('news') }}"><strong>News</strong><i class="fas fa-bell"></i></a>
                    @else
                        <a class="nav-link" href="{{ url('news') }}">News</a>
                    @endif
                </li>
                <li class="nav-item">
                    @if(Auth::check() && Auth::user()->is_sales_unread && Config::get('lorekeeper.extensions.navbar_news_notif'))
                        <a class="nav-link d-flex text-warning" href="{{ url('sales') }}"><strong>Sales</strong><i class="fas fa-bell"></i></a>
                    @else
                        <a class="nav-link" href="{{ url('sales') }}">Sales</a>
                    @endif
                </li>
                @if(Auth::check())
                    <li class="nav-item dropdown">
                        <a id="inventoryDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            My Account
                        </a>
                        <div class="dropdown-menu" aria-labelledby="inventoryDropdown">
                            <a class="dropdown-item" href="{{ url('characters') }}">
                                My Characters
                            </a>
                            <a class="dropdown-item" href="{{ url('characters/myos') }}">
                                My MYO Slots
                            </a>
                            <a class="dropdown-item" href="{{ url('inventory') }}">
                                Inventory
                            </a>
                            <a class="dropdown-item" href="{{ url('bank') }}">
                                Bank
                            </a>
                            <a class="dropdown-item" href="{{ url('research/unlocked') }}">
                                My Research
                                </a>
                            <a class="dropdown-item" href="{{ url('level') }}">
                                Level Area
                            </a>
                            <a class="dropdown-item" href="{{ url('designs') }}">
                                My Design Approvals
                            </a>
                            <a class="dropdown-item" href="{{ url('surrenders') }}">
                                My Surrenders
                                </a>
                            <a class="dropdown-item" href="{{ url('characters/transfers/incoming') }}">
                                My Character Transfers
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="queueDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Activities
                        </a>
                        <div class="dropdown-menu" aria-labelledby="browseDropdown">
					    <a class="dropdown-item" href="{{ url('info/achievements') }}">
                            Achievements
                        </a>
                        <a class="dropdown-item" href="{{ url('crafting') }}">
                            Crafting
                            </a>
                        <a class="dropdown-item" href="{{ url('info/guilds') }}">
                            Guilds
                        </a>
                        <a class="dropdown-item" href="{{ url('info/questing') }}">
                            Questing
                        </a>
                        <a class="dropdown-item" href="{{ url('prompts/prompts') }}">
                            Prompts
                        </a>
						<a class="dropdown-item" href="{{ url('info/growingyourbean') }}">
                            Growing your Beanling
                        </a>
                        <a class="dropdown-item" href="{{ url('research-trees') }}">
                            Research
                        </a>
                    </div>
                    </li>
                @endif
                <li class="nav-item dropdown">
                    <a id="browseDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Browse
                    </a>

                    <div class="dropdown-menu" aria-labelledby="browseDropdown">
                        <a class="dropdown-item" href="{{ url('users') }}">
                            Users
                        </a>
                        <a class="dropdown-item" href="{{ url('masterlist') }}">
                            Character Masterlist
                        </a>
                        <a class="dropdown-item" href="{{ url('myos') }}">
                            MYO Slot Masterlist
                        </a>
                    <a class="dropdown-item" href="{{ url('gallery') }}">
                    Art Gallery
                    </a>
                        <a class="dropdown-item" href="{{ url('reports/bug-reports') }}">
                            Bug Reports
                        </a>
                                                <a class="dropdown-item" href="{{ url('adoptions') }}">
                            Adoption Center
                        </a>
                        <a class="dropdown-item" href="{{ url('info/FAQ') }}">
                            FAQ
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                        <a id="queueDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Shops
                        </a>
                        <div class="dropdown-menu" aria-labelledby="browseDropdown">
					    <a class="dropdown-item" href="{{ url('shops') }}">
                            Shop Bazaar
                        </a>
                        <a class="dropdown-item" href="{{ url('https://teespring.com/stores/beanlingpatch') }}">
                            Merchandise Store
                            </a>
                        <a class="dropdown-item" href="{{ url('https://beanlingpatch.my-online.store/') }}">
                            Cash Purchase Store
                        </a>
                    </div>
                    </li>
                <li class="nav-item dropdown">
                    <a id="loreDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        World
                    </a>

                    <div class="dropdown-menu" aria-labelledby="loreDropdown">
                        <a class="dropdown-item" href="{{ url('info/newplayerguide') }}">
                            New Player Guide
                        </a>
                        <a class="dropdown-item" href="{{ url('world') }}">
                            Encyclopedia
                        </a>
                        <a class="dropdown-item" href="{{ url('world/info') }}">
                            World Expanded
                        </a>
                        						<a class="dropdown-item" href="{{ url('info/lore') }}">
                            Lore Directory
                        </a>
						<a class="dropdown-item" href="{{ url('info/stats') }}">
                            Stats
                        </a>
                        <a class="dropdown-item" href="{{ url('info/NPCs') }}">
                            NPCs
                        </a>
                        <a class="dropdown-item" href="{{ url('info/discord') }}">
                            Discord
                        </a>
                    </div>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    @if(Auth::user()->isStaff)
                        <li class="nav-item d-flex">
                            <a class="nav-link position-relative display-inline-block" href="{{ url('admin') }}"><i class="fas fa-crown"></i>
                              @if (Auth::user()->hasAdminNotification(Auth::user()))
                                <span class="position-absolute rounded-circle bg-danger text-light" style="top: -2px; right: -5px; padding: 1px 6px 1px 6px; font-weight:bold; font-size: 0.8em; box-shadow: 1px 1px 1px rgba(0,0,0,.25);">
                                  {{ Auth::user()->hasAdminNotification(Auth::user()) }}
                                </span>
                              @endif
                            </a>
                        </li>
                    @endif
                    @if(Auth::user()->notifications_unread)
                        <li class="nav-item">
                            <a class="nav-link btn btn-secondary btn-sm" href="{{ url('notifications') }}"><span class="fas fa-envelope"></span> {{ Auth::user()->notifications_unread }}</a>
                        </li>
                    @endif

                    <li class="nav-item dropdown">
                        <a id="browseDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Submit
                        </a>

                        <div class="dropdown-menu" aria-labelledby="browseDropdown">
                            <a class="dropdown-item" href="{{ url('submissions') }}">
                                Submit Prompt
                            </a>
                            <a class="dropdown-item" href="{{ url('claims') }}">
                                Submit Claim
                            </a>
                            <a class="dropdown-item" href="{{ url('reports') }}">
                                Submit Bug Report
                            </a>
                            <a class="dropdown-item" href="{{ url('trades/open') }}">
                                Submit Trades
                            </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="{{ Auth::user()->url }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ Auth::user()->url }}">
                                Profile
                            </a>
                            <a class="dropdown-item" href="{{ url('notifications') }}">
                                Notifications
                            </a>
                            <a class="dropdown-item" href="{{ url('account/bookmarks') }}">
                                Bookmarks
                            </a>
                            <a class="dropdown-item" href="{{ url('account/settings') }}">
                                Settings
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
