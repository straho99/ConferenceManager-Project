namespace ConferenceManager.Models
{
    using System.Collections.Generic;
    using System.ComponentModel.DataAnnotations;

    public class User
    {
        private ICollection<Conference> myConferences;
        private ICollection<Conference> attendingConferences;

        private ICollection<Lecture> myLectures;
        private ICollection<Lecture> attendingLectures;
        private ICollection<SpeakerInvitation> mySpeakerInvitations;

        private ICollection<Venue> myVenues;

        private ICollection<Notification> notifications;

        private ICollection<Message> sentMessages;
        private ICollection<Message> recievedMessages;

        public User()
        {
            this.myConferences = new HashSet<Conference>();
            this.attendingConferences = new HashSet<Conference>();

            this.myLectures = new HashSet<Lecture>();
            this.attendingLectures = new HashSet<Lecture>();
            this.mySpeakerInvitations = new HashSet<SpeakerInvitation>();

            this.myVenues = new HashSet<Venue>();

            this.notifications = new HashSet<Notification>();

            this.sentMessages = new HashSet<Message>();
            this.recievedMessages = new HashSet<Message>();
        }

        [Key]
        public int Id { get; set; }

        [Required]
        public string Username { get; set; }

        [Required]
        public string Email { get; set; }

        public string Telephone { get; set; }

        public virtual Role Role { get; set; }

        public virtual ICollection<Conference> MyConferences
        {
            get
            {
                return this.myConferences;
            }

            set
            {
                this.myConferences = value;
            }
        }

        public virtual ICollection<Conference> AttendingConferences
        {
            get
            {
                return this.attendingConferences;
            }

            set
            {
                this.attendingConferences = value;
            }
        }

        public virtual ICollection<Lecture> MyLectures
        {
            get
            {
                return this.myLectures;
            }

            set
            {
                this.myLectures = value;
            }
        }

        public virtual ICollection<Lecture> AttendingLectures
        {
            get
            {
                return this.attendingLectures;
            }

            set
            {
                this.attendingLectures = value;
            }
        }

        public virtual ICollection<SpeakerInvitation> MySpeakerInvitations
        {
            get
            {
                return this.mySpeakerInvitations;
            }

            set
            {
                this.mySpeakerInvitations = value;
            }
        }

        public virtual ICollection<Venue> MyVenues
        {
            get
            {
                return this.myVenues;
            }

            set
            {
                this.myVenues = value;
            }
        }

        public virtual ICollection<Notification> Notifications
        {
            get
            {
                return this.notifications;
            }

            set
            {
                this.notifications = value;
            }
        }

        public virtual ICollection<Message> SentMessages
        {
            get
            {
                return this.sentMessages;
            }

            set
            {
                this.sentMessages = value;
            }
        }

        public virtual ICollection<Message> RecievedMessages
        {
            get
            {
                return this.recievedMessages;
            }

            set
            {
                this.recievedMessages = value;
            }
        }
    }
}