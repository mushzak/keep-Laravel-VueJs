// Load dependencies and settings
require('./bootstrap');

// Load Vue Bootstrap implementation
import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);

// Load global components
Vue.component('base-modal', require('./components/modals/BaseModal.vue'));
Vue.component('create-discussion-form', require('./components/forms/CreateDiscussionForm.vue'));
Vue.component('create-feedback-form', require('./components/forms/CreateFeedbackForm.vue'));
Vue.component('create-meeting-agenda-form', require('./components/forms/CreateMeetingAgendaForm.vue'));
Vue.component('create-meeting-form', require('./components/forms/CreateMeetingForm.vue'));
Vue.component('date-format', require('./components/DateFormat.vue'));
Vue.component('discussion-thread', require('./components/discussions/DiscussionThread.vue'));
Vue.component('delete-record-button', require('./components/DeleteRecordButton.vue'));
Vue.component('edit-action-plan', require('./components/profile/EditActionPlan.vue'));
Vue.component('edit-big-picture', require('./components/profile/EditBigPicture.vue'));
Vue.component('edit-goals-and-objectives', require('./components/profile/EditGoalsAndObjectives.vue'));
Vue.component('edit-personal-background', require('./components/profile/EditPersonalBackground.vue'));
Vue.component('edit-professional-background', require('./components/profile/EditProfessionalBackground.vue'));
Vue.component('edit-personal-motivation', require('./components/profile/EditPersonalMotivation.vue'));
Vue.component('edit-big-picture', require('./components/profile/EditBigPicture.vue'));
Vue.component('edit-contact-info', require('./components/profile/EditContactInfo.vue'));
Vue.component('edit-group-profile', require('./components/forms/EditGroupProfile.vue'));
Vue.component('edit-meeting-agenda-form', require('./components/forms/EditMeetingAgendaForm.vue'));
Vue.component('edit-meeting-form', require('./components/forms/EditMeetingForm.vue'));
Vue.component('effort-chart', require('./components/metrics/EffortChart.vue'));
Vue.component('engagement-chart', require('./components/metrics/EngagementChart.vue'));
Vue.component('finish-process-form', require('./components/forms/FinishProcessForm.vue'));
Vue.component('flash-message', require('./components/FlashMessage.vue'));
Vue.component('meeting-room', require('./components/MeetingRoom.vue'));
Vue.component('leave-feedback', require('./components/forms/LeaveFeedback.vue'));
Vue.component('list-meeting-agendas', require('./components/ListMeetingAgendas.vue'));
Vue.component('manage-check-in-form', require('./components/forms/ManageCheckInForm.vue'));
Vue.component('modal-discussion-thread', require('./components/discussions/ModalDiscussionThread.vue'));
Vue.component('observe-discussions', require('./components/discussions/ObserveDiscussions.vue'));
Vue.component('discussion-list', require('./components/discussions/DiscussionList.vue'));
Vue.component('onboarding-verify-form', require('./components/onboarding/OnboardingVerifyForm.vue'));
Vue.component('onboarding-expectations-form', require('./components/onboarding/OnboardingExpectationsForm.vue'));
Vue.component('post-request-link', require('./components/PostRequestLink.vue'));
Vue.component('progress-chart', require('./components/metrics/ProgressChart.vue'));
Vue.component('ranking-chart', require('./components/metrics/RankingChart.vue'));
Vue.component('feedback-chart', require('./components/metrics/FeedbackChart.vue'));
Vue.component('sidebar-nav', require('./components/SidebarNav.vue'));
Vue.component('text-decorator', require('./components/TextDecorator.vue'));
Vue.component('manage-member', require('./components/manage/ManageMember.vue'));
Vue.component('manage-invites', require('./components/manage/ManageInvites.vue'));
Vue.component('big-picture', require('./components/profile/BigPicture.vue'));
Vue.component('action-plan', require('./components/profile/ActionPlan.vue'));
Vue.component('personal-motivation', require('./components/profile/PersonalMotivation.vue'));
Vue.component('contact-info', require('./components/profile/ContactInfo.vue'));
Vue.component('personal-background', require('./components/profile/PersonalBackground.vue'));
Vue.component('professional-background', require('./components/profile/ProfessionalBackground.vue'));
Vue.component('goals-and-objectives', require('./components/profile/GoalsAndObjectives.vue'));
Vue.component('group-profile', require('./components/profile/GroupProfile.vue'));


// Group config global components
Vue.component('edit-group-about-form', require('./components/group-config/EditGroupAboutForm.vue'));
Vue.component('edit-group-agreements-form', require('./components/group-config/EditGroupAgreementsForm.vue'));
Vue.component('edit-group-check-ins-form', require('./components/group-config/EditGroupCheckInsForm.vue'));
Vue.component('edit-group-feedback-form', require('./components/group-config/EditGroupFeedbackForm.vue'));
Vue.component('edit-group-member-engagement-form', require('./components/group-config/EditGroupMemberEngagementForm.vue'));
Vue.component('edit-group-member-plan-form', require('./components/group-config/EditGroupMemberPlanForm.vue'));
Vue.component('edit-group-member-profile-form', require('./components/group-config/EditGroupMemberProfileForm.vue'));

// Accounts global components
Vue.component('edit-account-branding-form', require('./components/accounts/EditAccountBrandingForm.vue'));
Vue.component('edit-account-contact-form', require('./components/accounts/EditAccountContactForm.vue'));
Vue.component('edit-account-group-form', require('./components/accounts/EditAccountGroupForm.vue'));
Vue.component('edit-account-integrations-form', require('./components/accounts/EditAccountIntegrationsForm.vue'));
Vue.component('edit-account-security-form', require('./components/accounts/EditAccountSecurityForm.vue'));
Vue.component('edit-account-subscription-form', require('./components/accounts/EditAccountSubscriptionForm.vue'));
Vue.component('edit-account-notifications-form', require('./components/accounts/EditAccountNotificationsForm.vue'));

// Vue root instance
new Vue({
    el: "#app",
});
