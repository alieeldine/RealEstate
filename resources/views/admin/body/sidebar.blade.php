        <nav class="sidebar">
          <div class="sidebar-header">
            <a href="#" class="sidebar-brand">
              Easy<span>Learning</span>
            </a>
            <div class="sidebar-toggler not-active">
              <span></span>
              <span></span>
              <span></span>
            </div>
          </div>
          <div class="sidebar-body">
            <ul class="nav">
              <li class="nav-item nav-category">Main</li>
              <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                  <i class="link-icon" data-feather="box"></i>
                  <span class="link-title">Dashboard</span>
                </a>
              </li>
              <li class="nav-item nav-category">RealEstate</li>
              
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#emails" role="button" aria-expanded="false" aria-controls="emails">
                  <i class="link-icon" data-feather="mail"></i>
                  <span class="link-title">Proterty Type</span>
                  <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="emails">
                  <ul class="nav sub-menu">
                    <li class="nav-item">
                      <a href="{{ route('all.types') }}" class="nav-link">All Types</a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('add.type') }}" class="nav-link">Add Type</a>
                    </li>                    
                  </ul>
                </div>
              </li>

              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#amenities" role="button" aria-expanded="false" aria-controls="emails">
                  <i class="link-icon" data-feather="mail"></i>
                  <span class="link-title">Amenities</span>
                  <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="amenities">
                  <ul class="nav sub-menu">
                    <li class="nav-item">
                      <a href="{{ route('all.amenities') }}" class="nav-link">All Amenities</a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('add.amenitie') }}" class="nav-link">Add amenitie</a>
                    </li>                    
                  </ul>
                </div>
              </li>

              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#properties" role="button" aria-expanded="false" aria-controls="emails">
                  <i class="link-icon" data-feather="mail"></i>
                  <span class="link-title">Properties</span>
                  <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="properties">
                  <ul class="nav sub-menu">
                    <li class="nav-item">
                      <a href="{{ route('all.properties') }}" class="nav-link">All Properties</a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('add.property') }}" class="nav-link">Add amenitie</a>
                    </li>                    
                  </ul>
                </div>
              </li>

              <li class="nav-item">
                <a href="pages/apps/calendar.html" class="nav-link">
                  <i class="link-icon" data-feather="calendar"></i>
                  <span class="link-title">Calendar</span>
                </a>
              </li>
              <li class="nav-item nav-category">Components</li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#uiComponents" role="button" aria-expanded="false" aria-controls="uiComponents">
                  <i class="link-icon" data-feather="feather"></i>
                  <span class="link-title">UI Kit</span>
                  <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="uiComponents">
                  <ul class="nav sub-menu">
                    <li class="nav-item">
                      <a href="pages/ui-components/accordion.html" class="nav-link">Accordion</a>
                    </li>
                    <li class="nav-item">
                      <a href="pages/ui-components/alerts.html" class="nav-link">Alerts</a>
                    </li>
                    
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI" role="button" aria-expanded="false" aria-controls="advancedUI">
                  <i class="link-icon" data-feather="anchor"></i>
                  <span class="link-title">Advanced UI</span>
                  <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="advancedUI">
                  <ul class="nav sub-menu">
                    <li class="nav-item">
                      <a href="pages/advanced-ui/cropper.html" class="nav-link">Cropper</a>
                    </li>
                    <li class="nav-item">
                      <a href="pages/advanced-ui/owl-carousel.html" class="nav-link">Owl carousel</a>
                    </li>
                  </ul>
                </div>
              </li>

              <li class="nav-item nav-category">Docs</li>
              <li class="nav-item">
                <a href="#" target="_blank" class="nav-link">
                  <i class="link-icon" data-feather="hash"></i>
                  <span class="link-title">Documentation</span>
                </a>
              </li>
            </ul>
          </div>
        </nav>