export const applicantInfo = {
    name: '',
    email: '',
    phone: '',
    sin: null,
    dob: null,
    marital_status: '', // Make sure to match the field name to your schema
    license_number: '',
    license_expiry: null,
}

export const applicantAddress = {
    address: '',
    city: '',
    province: '',
    postal_code: '',
    residence_type: '',
    rent_mortgage_amount: null,
}

export const applicantEmployer = {
    employer: '',
    employer_phone: '',
    job_title: '',
    job_length: '',
    income_amount: '',
    income_frequency: '',
    employer_address: '',
    employer_city: '',
    employer_province: '',
    employer_postal_code: '',
}

export const financeDefaultData = {
    ...applicantInfo,
    ...applicantAddress,
    ...applicantEmployer,
    co_applicant: {},
    trade_in: {},
};
