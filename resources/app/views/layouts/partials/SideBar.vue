<template>
    <div class="main-navbar side-menu main-sidebar-sticky">
        <div class="sidemenu-logo">
            <a class="main-logo" href="/dashboard">
                <img
                    :src="`${publicPath}/assets/images/logo.png`"
                    class="header-brand-img desktop-logo"
                    alt="logo"
                />
                <img
                    :src="`${publicPath}/assets/images/roqay-logo.png`"
                    class="header-brand-img icon-logo"
                    alt="logo"
                />
                <img
                    :src="`${publicPath}/assets/images/logo-light.png`"
                    class="header-brand-img desktop-logo theme-logo"
                    alt="logo"
                />
                <img
                    :src="`${publicPath}/assets/images/icon-light.png`"
                    class="header-brand-img icon-logo theme-logo"
                    alt="logo"
                />
            </a>
        </div>
        <div class="container main-sidemenu">
            <div class="main-sidebar-body">
                <ul class="nav">
                    <li
                        :class="`nav-item ${
                            this.$route.name === 'dashboard' ? 'active' : ''
                        }`"
                    >
                        <router-link to="/dashboard" class="nav-link">
                            <i class="las la-tv me-2"></i>
                            <span class="sidemenu-label">{{
                                $t("sidebar.dashboard")
                            }}</span>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link subMenu with-sub">
                            <i class="fas fa-users-class me-2"></i>
                            <span class="sidemenu-label">{{
                                $t("sidebar.hr")
                            }}</span>
                        </a>
                        <ul class="nav-sub">
                            <li
                                :class="`nav-sub-item${
                                    this.$route.name === 'employees' ? 'active' : ''
                                }`"
                                v-if="hasPermission('read', 'User')"
                            >
                                <router-link to="/employees" class="nav-link">
                                    <i class="las la-users me-2"></i>
                                    <span class="sidemenu-label">{{
                                        $t("sidebar.teams")
                                    }}</span>
                                </router-link>
                            </li>
                            <li
                                :class="`nav-sub-item${
                                    this.$route.name === 'leaves'
                                        ? 'active'
                                        : ''
                                }`"
                                v-if="hasPermission('read', 'Leave')"
                            >
                                <router-link to="/leaves" class="nav-sub-link">
                                    <span class="sidemenu-label">{{
                                        $t("sidebar.leaves")
                                    }}</span>
                                </router-link>
                            </li>

                            <li
                                :class="`nav-sub-item${
                                    this.$route.name === 'leave-credits'
                                        ? 'active'
                                        : ''
                                }`"
                                v-if="hasPermission('read', 'LeaveCredit')"
                            >
                                <router-link
                                    to="/leave-credits"
                                    class="nav-sub-link"
                                >
                                    <span class="sidemenu-label">{{
                                        $t("sidebar.leave_credits")
                                    }}</span>
                                </router-link>
                            </li>

                            <li
                                :class="`nav-sub-item${
                                    this.$route.name === 'deductions'
                                        ? 'active'
                                        : ''
                                }`"
                                v-if="hasPermission('read', 'Deduction')"
                            >
                                <router-link
                                    :to="{ name: 'deductions' }"
                                    class="nav-sub-link"
                                >
                                    <span class="sidemenu-label">{{
                                        $t("sidebar.deductions")
                                    }}</span>
                                </router-link>
                            </li>

                            <li
                                :class="`nav-sub-item${
                                    this.$route.name === 'applicants' ||
                                    this.$route.name === 'applicants.create'
                                        ? 'active'
                                        : ''
                                }`"
                                v-if="
                                    hasPermission('read', 'Applicant') ||
                                    hasPermission('create', 'Applicant')
                                "
                            >
                                <router-link
                                    :to="{ name: 'applicants' }"
                                    class="nav-sub-link"
                                >
                                    <span class="sidemenu-label">{{
                                        $t("sidebar.applicants")
                                    }}</span>
                                </router-link>
                            </li>

                            <li
                                :class="`nav-sub-item${
                                    this.$route.name === 'overtime'
                                        ? 'active'
                                        : ''
                                }`"
                                v-if="hasPermission('read', 'Overtime')"
                            >
                                <router-link
                                    to="/overtimes"
                                    class="nav-sub-link"
                                >
                                    <span class="sidemenu-label">{{
                                        $t("sidebar.overtimes")
                                    }}</span>
                                </router-link>
                            </li>
                            <li
                                :class="`nav-sub-item${
                                    this.$route.name === 'award-types'
                                        ? 'active'
                                        : ''
                                }`"
                                v-if="hasPermission('read', 'AwardType')"
                            >
                                <router-link to="/award-types" class="nav-sub-link">
                                    <span class="sidemenu-label">{{
                                        $t("sidebar.award_types")
                                    }}</span>
                                </router-link>
                            </li>
                            <li
                                :class="`nav-sub-item${
                                    this.$route.name === 'awards'
                                        ? 'active'
                                        : ''
                                }`"
                                v-if="hasPermission('read', 'Award')"
                            >
                                <router-link to="/awards" class="nav-sub-link">
                                    <span class="sidemenu-label">{{
                                        $t("sidebar.awards")
                                    }}</span>
                                </router-link>
                            </li>
                        </ul>
                    </li>

                    <li
                        class="nav-item"
                        v-if="
                            hasAnyPermission('read', [
                                'AssetModel',
                                'AssetItem',
                            ])
                        "
                    >
                        <a class="nav-link subMenu with-sub">
                            <i class="fas fa-users-class me-2"></i>
                            <span class="sidemenu-label">{{
                                $t("sidebar.assets")
                            }}</span>
                        </a>
                        <ul class="nav-sub">
                            <li
                                :class="`nav-sub-item${
                                    this.$route.name === 'assets.models'
                                        ? 'active'
                                        : ''
                                }`"
                                v-if="hasPermission('read', 'AssetModel')"
                            >
                                <router-link
                                    :to="{ name: 'assets.models' }"
                                    class="nav-sub-link"
                                >
                                    <span class="sidemenu-label">{{
                                        $t("sidebar.assets_models")
                                    }}</span>
                                </router-link>
                            </li>

                            <li
                                :class="`nav-sub-item${
                                    this.$route.name === 'assets.items'
                                        ? 'active'
                                        : ''
                                }`"
                                v-if="hasPermission('read', 'AssetItem')"
                            >
                                <router-link
                                    :to="{ name: 'assets.items' }"
                                    class="nav-sub-link"
                                >
                                    <span class="sidemenu-label">{{
                                        $t("sidebar.assets_items")
                                    }}</span>
                                </router-link>
                            </li>
                        </ul>
                    </li>

                    <li
                        class="nav-item"
                        v-if="
                            hasAnyPermission('read', [
                                'Project',
                                'Company',
                                'Customer',
                            ])
                        "
                    >
                        <a class="nav-link subMenu with-sub">
                            <i class="far fa-folder-open me-2"></i>
                            <span class="sidemenu-label">{{
                                $t("sidebar.projects")
                            }}</span>
                        </a>
                        <ul class="nav-sub">
                            <li
                                :class="`nav-sub-item${
                                    this.$route.name === 'projects'
                                        ? 'active'
                                        : ''
                                }`"
                                v-if="hasPermission('read', 'Project')"
                            >
                                <router-link
                                    to="/projects"
                                    class="nav-sub-link"
                                >
                                    <span class="sidemenu-label">{{
                                        $t("sidebar.projects")
                                    }}</span>
                                </router-link>
                            </li>

                            <li
                                :class="`nav-sub-item${
                                    this.$route.name === 'companies'
                                        ? 'active'
                                        : ''
                                }`"
                                v-if="hasPermission('read', 'Company')"
                            >
                                <router-link
                                    to="/companies"
                                    class="nav-sub-link"
                                >
                                    <span class="sidemenu-label">{{
                                        $t("sidebar.companies")
                                    }}</span>
                                </router-link>
                            </li>

                            <li
                                :class="`nav-sub-item${
                                    this.$route.name === 'customers'
                                        ? 'active'
                                        : ''
                                }`"
                                v-if="hasPermission('read', 'Customer')"
                            >
                                <router-link
                                    to="/customers"
                                    class="nav-sub-link"
                                >
                                    <span class="sidemenu-label">{{
                                        $t("sidebar.customers")
                                    }}</span>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li
                        :class="`nav-item ${
                            this.$route.name === 'tickets' ? 'active' : ''
                        }`"
                        v-if="hasPermission('read', 'Ticket')"
                    >
                        <router-link :to="{ name: 'tickets' }" class="nav-link">
                            <i class="fas fa-ticket-alt me-2"></i>
                            <span class="sidemenu-label">{{
                                $t("sidebar.tickets")
                            }}</span>
                        </router-link>
                    </li>
                    <li
                        :class="`nav-item ${
                            this.$route.name === 'slas' ||
                            this.$route.name === 'slas.create'
                                ? 'active'
                                : ''
                        }`"
                        v-if="hasPermission('read', 'Sla')"
                    >
                        <router-link :to="{ name: 'slas' }" class="nav-link">
                            <i class="far fa-clock me-2"></i>
                            <span class="sidemenu-label">{{
                                $t("sidebar.slas")
                            }}</span>
                        </router-link>
                    </li>

                    <li
                        :class="`nav-item ${
                            this.$route.name === 'archive-documents'
                                ? 'active'
                                : ''
                        }`"
                        v-if="hasPermission('read', 'ArchiveDocument')"
                    >
                        <router-link
                            :to="{ name: 'archive-documents' }"
                            class="nav-link"
                        >
                            <i class="far fa-file-archive me-2"></i>
                            <span class="sidemenu-label">{{
                                $t("sidebar.archiveDocument")
                            }}</span>
                        </router-link>
                    </li>

                    <li
                        :class="`nav-item ${
                            this.$route.name === 'our.team'
                                ? 'active'
                                : ''
                        }`"
                        v-if="hasPermission('read', 'Employee')"
                    >
                        <router-link :to="{ name: 'our.team' }" class="nav-link">
                            <i class="las la-users me-2"></i>
                            <span class="sidemenu-label">{{
                                    $t("sidebar.our-team")
                                }}</span>
                        </router-link>
                    </li>

                    <li
                        :class="`nav-item ${
                            this.$route.name === 'memos.index' ||
                            this.$route.name === 'memos.create'
                                ? 'active'
                                : ''
                        }`"
                        v-if="hasPermission('read', 'Memo')"
                    >
                        <router-link :to="{ name: 'memos.index' }" class="nav-link">
                            <i class="far fa-clock me-2"></i>
                            <span class="sidemenu-label">{{
                                    $t("sidebar.memos")
                                }}</span>
                        </router-link>
                    </li>

                    <li
                        class="nav-item"
                        v-if="
                            hasAnyPermission('read', [
                                'Opportunity',
                                'OpportunityStatus',
                            ])
                        "
                    >
                        <a class="nav-link subMenu with-sub">
                            <i class="fas fa-users-class me-2"></i>
                            <span class="sidemenu-label">{{
                                $t("sidebar.opportunities")
                            }}</span>
                        </a>
                        <ul class="nav-sub">
                            <li
                                :class="`nav-sub-item${
                                    this.$route.name === 'opportunities'
                                        ? 'active'
                                        : ''
                                }`"
                                v-if="hasPermission('read', 'Opportunity')"
                            >
                                <router-link
                                    :to="{ name: 'opportunities' }"
                                    class="nav-sub-link"
                                >
                                    <span class="sidemenu-label">{{
                                        $t("sidebar.opportunities")
                                    }}</span>
                                </router-link>
                            </li>

                            <li
                                :class="`nav-sub-item${
                                    this.$route.name === 'opportunities.status'
                                        ? 'active'
                                        : ''
                                }`"
                                v-if="
                                    hasPermission('read', 'OpportunityStatus')
                                "
                            >
                                <router-link
                                    :to="{ name: 'opportunities.status' }"
                                    class="nav-sub-link"
                                >
                                    <span class="sidemenu-label">{{
                                        $t("sidebar.opportunity_status")
                                    }}</span>
                                </router-link>
                            </li>
                        </ul>
                    </li>

                    <li
                        class="nav-item"
                        v-if="
                            hasAnyPermission('read', [
                                'Role',
                                'Department',
                                'Holiday',
                                'WorkRegulation',
                                'QuestionGroup',
                                'InterviewQuestion',
                            ])
                        "
                    >
                        <a class="nav-link subMenu with-sub">
                            <i class="fas fa-sliders me-2"></i>
                            <span class="sidemenu-label">{{
                                $t("pages.setups")
                            }}</span>
                        </a>
                        <ul class="nav-sub">
                            <li :class="`nav-sub-item${this.$route.name === 'roles'? 'active': ''}`"
                                v-if="hasPermission('read', 'Role')">
                                <router-link to="/roles" class="nav-sub-link">
                                    <span class="sidemenu-label">{{ $t("sidebar.roles") }}</span>
                                </router-link>
                            </li>
                            <li :class="`nav-sub-item${this.$route.name === 'departments'? 'active': ''}`"
                                v-if="hasPermission('read', 'Department')">
                                <router-link to="/departments" class="nav-sub-link">
                                    <span class="sidemenu-label">{{ $t("sidebar.departments") }}</span>
                                </router-link>
                            </li>
                            <li :class="`nav-sub-item${this.$route.name === 'holidays'? 'active': ''}`"
                                v-if="hasPermission('read', 'Holiday')">
                                <router-link to="/holidays" class="nav-sub-link">
                                    <span class="sidemenu-label">{{$t("sidebar.holidays")}}</span>
                                </router-link>
                            </li>
                            <li :class="`nav-sub-item${this.$route.name === 'work-regulations'? 'active': ''}`"
                                v-if="hasPermission('read', 'WorkRegulation')">
                                <router-link to="/work-regulations" class="nav-sub-link">
                                    <span class="sidemenu-label">
                                        {{$t("sidebar.work_regulations")}}
                                    </span>
                                </router-link>
                            </li>
                            <li :class="`nav-sub-item${this.$route.name === 'question-groups'? 'active': ''}`"
                                v-if="hasPermission('read', 'QuestionGroup')">
                                <router-link to="/question-groups" class="nav-sub-link">
                                    <span class="sidemenu-label">{{$t("sidebar.question_groups")}}</span>
                                </router-link>
                            </li>

                            <li :class="`nav-sub-item${this.$route.name === 'interview-questions'? 'active': ''}`"
                                v-if="hasPermission('read', 'InterviewQuestion')">
                                <router-link :to="{ name: 'interview-questions' }" class="nav-sub-link">
                                    <span class="sidemenu-label">{{ $t("sidebar.interview_questions") }}</span>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "side-bar",
    mounted: function () {
        $(".main-navbar .subMenu").on("click", function (e) {
            e.preventDefault();
            $(this).parent().toggleClass("show");
            $(this).parent().siblings().removeClass("show");
        });

        $("body").append('<div class="main-navbar-backdrop"></div>');

        $(".main-navbar-backdrop").on("click touchstart", function () {
            $("body").removeClass("main-navbar-show");
        });
    },
};
</script>
