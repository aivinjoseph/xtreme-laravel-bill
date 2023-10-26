<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

const policies = [
  {
    "title": "1 – WHAT DO WE DO WITH YOUR INFORMATION",
    "description": "When you use our website, as part of the purchase process, we collect the personal information you give us such as your name, address and email address. When you browse our website, we also automatically receive your computer’s internet protocol (IP) address in order to provide us with information that helps us learn about your browser and operating system. With your permission, we may send you emails about our website, new products and other updates."
  },
  {
    "title": "2 – CONSENT",
    "description": "When you provide us with personal information via an inquiry, we imply that you consent to our collecting it and using it for that specific reason only. If we ask for your personal information for a secondary reason, like marketing, we will either ask you directly for your expressed consent, or provide you with an opportunity to say no. If after you opt-in, you change your mind, you may withdraw your consent for us to contact you, for the continued collection, use or disclosure of your information, at any time, by contacting us."
  },
  {
    "title": "3 – DISCLOSURE",
    "description": "We may disclose your personal information if we are required by law to do so. If you use your credit card to reserve a vehicle or order parts or a service, then Xtreme Motors Inc. stores your credit card data. It is encrypted through the Payment Card Industry Data Security Standard (PCI-DSS). Your purchase transaction data is stored only as long as it is necessary to complete your purchase transaction. After that is complete, your purchase transaction information is deleted. All direct payment gateways adhere to the standards set by PCI-DSS as managed by the PCI Security Standards Council, which is a joint effort of brands like Visa, MasterCard, American Express and Discover."
  },
  {
    "title": "4 – THIRD PARTY SERVICES",
    "description": "In general, the third-party service providers used by us will only collect, use and disclose your information to the extent necessary to allow them to perform the services they provide to us. However, certain third-party service providers, such as payment gateways and other payment transaction processors have their own privacy policies in respect to the information we are required to provide them for your purchase related transactions. We recommend that you read their privacy policies so you can understand the manner in which your personal information will be handled by these providers. In particular, remember that certain providers may be located in or have facilities that are located in a different jurisdiction than either you or us. So if you elect to proceed with a transaction that involves the services of a third-party service provider, then your information may become subject to the laws of the jurisdiction(s) in which that service provider or its facilities are located. Once you leave our website or are redirected to a third-party website or application, you are no longer governed by this Privacy Policy or our website’s Terms & Conditions."
  },
  {
    "title": "5 – SECURITY",
    "description": "To protect your personal information, we take reasonable precautions and follow industry best practices to make sure it is not inappropriately lost, misused, accessed, disclosed, altered or destroyed. If you provide us with your credit card information, the information is encrypted. Although no method of transmission over the Internet or electronic storage is 100% secure, we follow all requirements and implement additional generally accepted industry standards."
  },
  {
    "title": "6 – COOKIES",
    "description": "Here is a list of cookies that we use. We’ve listed them here so you that you can choose if you want to opt-out of cookies or not. _session_id, unique token, sessional to store information about your session (referrer, landing page, etc)."
  },
  {
    "title": "7 – ADVERTISING POLICY",
    "description": "1. Ensure any ad data collected, received or derived from your Facebook or Instagram ad (“Facebook advertising data”) is only shared with someone acting on your behalf, such as your service provider. You are responsible for ensuring your service providers protect any Facebook advertising data or any other information obtained from us, limit their use of all of that information, and keep it confidential and secure. 2. Don’t use Facebook advertising data for any purpose (including retargeting, commingling data across multiple advertisers’ campaigns, or allowing piggybacking or redirecting with tags), except on an aggregate and anonymous basis (unless authorized by Facebook) and only to assess the performance and effectiveness of your Facebook advertising campaigns. 3. Don’t use Facebook advertising data, including the targeting criteria for your ad, to build, append to, edit, influence, or augment user profiles, including profiles associated with any mobile device identifier or other unique identifier that identifies any particular user, browser, computer or device. 4. Don’t transfer any Facebook advertising data (including anonymous, aggregate, or derived data) to any ad network, ad exchange, data broker or other advertising related service."
  },
  {
    "title": "8 – AGE OF CONSENT",
    "description": "By using this site, you represent that you are at least the age of majority in your state or province of residence, or that you are the age of majority in your state or province of residence and you have given us your consent to allow any of your minor dependents to use this site."
  },
  {
    "title": "9 – CHANGES TO PRIVACY POLICY",
    "description": "We reserve the right to modify this privacy policy at any time, so please review it frequently. Changes and clarifications will take effect immediately upon their posting on the website. If we make material changes to this policy, we will notify you here that it has been updated, so that you are aware of what information we collect, how we use it, and under what circumstances, if any, we use and/or disclose it. If our website is acquired or merged with another company, your information may be transferred to the new owners so that we may continue to sell products to you."
  }
]

</script>

<template>
   <AppLayout title="Privacy Policy">
        <div class="max-w-4xl mx-auto p-4 lg:p-8">
            <h1 class="text-2xl font-semibold text-gray-900">Privacy Policy</h1>
            <div v-for="policy in policies" :key="policy.title">
                <h2 class="text-xl font-semibold text-gray-900 mt-4">{{ policy.title }}</h2>
                <p class="mt-2 text-sm text-gray-500">{{ policy.description }}</p>
            </div>
        </div>
   </AppLayout>
</template>
